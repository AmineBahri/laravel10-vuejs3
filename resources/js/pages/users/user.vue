<script setup>
import { ref } from 'vue';
import { onMounted } from '@vue/runtime-core';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import addUser from'./addUser.vue';

const users = ref([]);
const page = ref(1);
const isEdit = ref(false);
const user = ref({});
const fields = {
    'id':'id',
    'name':'name',
    'father_name':'father_name',
    'date_of_birth':'date_of_birth',
    'gender':'gender',
    'mobile':'mobile',
    'email':'email',
    'role':'role.name_role'
};
const notify = (message)=>{
    toast.success(message,{
        autoClose:3000,
        position:toast.POSITION.TOP_CENTER
    });
}
const notifyError = (message)=>{
    toast.error(message,{
        autoClose:3000,
        position:toast.POSITION.TOP_CENTER
    });
}
const adduser = ()=>{
    isEdit.value = true;
    user.value = false;
}
const userEdit = (userSelect)=>{
    isEdit.value = true;
    user.value = userSelect;
}
const getUsers = (page)=>{
    axios.get(`api/index-users?page={$page}`).then((res)=>{
        users.value = res.data.users.data;
        notify(res.data.message);
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}
const goBack = (event)=>{
    isEdit.value = event;
    user.value = false;
    getUsers(page)
}
onMounted(()=>{
    getUsers(page);
})
</script>
<template>
    <div>
        <addUser v-if="isEdit" :user="user" @goBack="goBack($event)"/>
        <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-header">
                <h4 class="card-title">users table</h4>
                <h4 class="card-title">
                    <download-excel class="btn btn-success" :data="users" worksheet="'worksheet'" :name="'name'" :fields="fields">download</download-excel>
                </h4>
                <button class="btn btn-primary btn-circle bts-sm float-end" @click="adduser">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td>Actions</td>
                                <td>id</td>
                                <td>name</td>
                                <td>email</td>
                                <td>mobile</td>
                                <td>Role Name</td>
                            </tr>
                        </thead>
                        <tfoot>

                        </tfoot>
                        <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>
                                    <button hidden class="btn btn-danger btn-circle bts-sm m-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button @click="userEdit(user)" class="btn btn-info btn-circle bts-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td>
                                    {{user.id}}
                                </td>
                                <td>
                                    {{user.name}}
                                </td>
                                <td>
                                    {{user.email}}
                                </td>
                                <td>
                                    {{user.mobile}}
                                </td>
                                <td>
                                    {{user.role?.name_role}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
