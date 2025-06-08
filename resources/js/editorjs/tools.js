import EditorJS from "@editorjs/editorjs";
import Header from "@editorjs/header";
import List from "@editorjs/list";
import Quote from "@editorjs/quote";
import ImageTool from "@editorjs/image";
import Embed from "@editorjs/embed";
import Table from "@editorjs/table";
import LinkTool from "@editorjs/link";
// import ColumnsBlock from "./ColumnsBlock"; 

export const editorJsTools = {
    header: Header,
    list: List,
    quote: Quote,
    image: {
        class: ImageTool,
        config: {
            endpoints: {
                byFile: "/admin/upload-image",
                byUrl: "/admin/fetch-image-from-url",
            },
            field: "image",
            types: "image/*",
            additionalRequestHeaders: (() => {
                const tokenMeta = document.querySelector(
                    'meta[name="csrf-token"]'
                );
                if (tokenMeta) {
                    return {
                        "X-CSRF-TOKEN": tokenMeta.getAttribute("content"),
                    };
                }

                return null;
            })(),
        },
    },
    embed: {
        class: Embed,
        inlineToolbar: false,
        config: {
            services: {
                youtube: true,
                coub: true,
                codepen: true,
                // add more services as needed
            },
        },
    },
    table: Table,
    linkTool: {
        class: LinkTool,
        config: {
            endpoint: "/admin/fetch-link-metadata",
        },
    },
    // columns: {
    //     class: ColumnsBlock,
    //     config: {
    //         tools: {
    //             header: Header,
    //             list: List,
    //             quote: Quote,
    //             image: ImageTool,
    //             embed: Embed,
    //             table: Table,
    //             linkTool: LinkTool,
    //         },
    //     },
    // },
};
