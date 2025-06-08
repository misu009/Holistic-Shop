import EditorJS from "@editorjs/editorjs";

export default class ColumnsBlock {
    static get toolbox() {
        return {
            title: "Columns",
            icon: "<svg>...</svg>", // optional icon SVG
        };
    }

    constructor({ data, api, config }) {
        this.api = api;
        this.config = config || {};
        this.tools = this.config.tools || {};
        this.data = data || {};
        this.nestedEditors = [];

        // Set default columns
        this.data.columns = Array.isArray(this.data.columns)
            ? this.data.columns
            : [{ content: { blocks: [] } }, { content: { blocks: [] } }];
    }

    render() {
        const container = document.createElement("div");
        container.classList.add("columns-block");

        // Ensure columns is always an array of objects
        this.data.columns = Array.isArray(this.data.columns)
            ? this.data.columns
            : [];

        const columnsCount = this.data.columns.length || 2;

        // Fill in empty columns if needed
        while (this.data.columns.length < columnsCount) {
            this.data.columns.push({ content: { blocks: [] } });
        }

        for (let i = 0; i < columnsCount; i++) {
            const column = document.createElement("div");
            column.classList.add("column");
            column.style.cssText = `width: ${
                100 / columnsCount
            }%; float: left; padding: 10px; box-sizing: border-box;`;

            const holder = document.createElement("div");
            holder.classList.add("nested-editor-holder");
            column.appendChild(holder);
            container.appendChild(column);

            const nestedData =
                this.data.columns[i] &&
                typeof this.data.columns[i].content === "object" &&
                this.data.columns[i].content.blocks
                    ? this.data.columns[i].content
                    : { blocks: [] };

            const editor = new EditorJS({
                holder,
                tools: this.tools,
                data: nestedData,
                readOnly: false,
                autofocus: false,
                onReady: () => {
                    console.log(`Editor ${i} ready`);
                },
            });

            this.nestedEditors.push(editor);
        }

        return container;
    }

    async save(blockContent) {
        const columnsContent = [];

        for (const editor of this.nestedEditors) {
            const savedData = await editor.save();
            columnsContent.push({ content: savedData });
        }

        return {
            columns: columnsContent,
        };
    }
}
