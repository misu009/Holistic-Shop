@extends('admin.layout')

@section('title', 'Admin User')

@section('content')
    <div class="container my-5">
        <x-alert-notification />
        <div class="d-flex justify-content-between align-items-center py-3">
            <h2 class="mx-auto">User Management</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                Add User
            </button>
        </div>
        <x-admin.users-table :users="$users" />
    </div>

    <x-admin.modal modalId="addUserModal" title="Add User" content="">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="modalId" id="modalId" value="addUserModal" required>
            <x-admin.input label-name="Username" attributes-param="type=text id=name required" name="name" />
            <x-admin.input label-name="Email" attributes-param="type=email id=email required" name="email" />
            <x-admin.input label-name="Pasword" attributes-param="type=password id=password required" name="password">
                <span class="position-absolute end-0 translate-middle-y pe-3" onclick="togglePasswordVisibility('password')"
                    style="cursor: pointer; margin-top:-20px;">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
            </x-admin.input>
            <x-admin.input label-name="Confirm pasword" attributes-param="type=password id=password_confirmation required"
                name="password_confirmation">
                <span class="position-absolute end-0 translate-middle-y pe-3"
                    onclick="togglePasswordVisibility('password_confirmation')" style="cursor: pointer; margin-top:-20px;">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
            </x-admin.input>
            <x-admin.input label-name="User Image <small class='text-danger'>(optional)</small>"
                attributes-param="type=file id=picture accept=image/*" name="picture" />
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Save User</button>
            </div>
        </form>
    </x-admin.modal>

    <x-admin.modal modalId="editUserModal" title="Edit User" content="">
        <form method="POST" enctype="multipart/form-data" id="editUserForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="modalId" value="editUserModal" required>
            <input type="hidden" name="editUserId" id="editUserId" required>
            <x-admin.input label-name="Username" attributes-param="type=text id=editName required" name="editName" />
            <x-admin.input label-name="Email" attributes-param="type=email id=editEmail required" name="editEmail" />
            <x-admin.input label-name="Pasword <small class='text-danger'>(optional)</small>"
                attributes-param="type=password id=edit_password" name="password">
                <span class="position-absolute end-0 translate-middle-y pe-3" onclick="togglePasswordVisibility('password')"
                    style="cursor: pointer; margin-top:-20px;">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
            </x-admin.input>
            <x-admin.input label-name="Confirm pasword" attributes-param="type=password id=edit_password_confirmation"
                name="password_confirmation">
                <span class="position-absolute end-0 translate-middle-y pe-3"
                    onclick="togglePasswordVisibility('password_confirmation')" style="cursor: pointer; margin-top:-20px;">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
            </x-admin.input>
            <x-admin.input label-name="User Image <small class='text-danger'>(optional)</small>"
                attributes-param="type=file id=edit-picture accept=image" name="picture" />
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Save User</button>
            </div>
        </form>
    </x-admin.modal>

@endsection

@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modalId = @json(old('modalId'));
            const userId = @json(old('editUserId'));
            console.log(userId);
            if (modalId === 'editUserModal') {
                const editUserForm = document.getElementById("editUserForm");
                editUserForm.action = `/admin/users/${userId}`;
            }
        });
    </script>
@endif
