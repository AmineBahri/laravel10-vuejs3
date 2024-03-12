<script setup>
import { ref } from 'vue';
import { onMounted } from '@vue/runtime-core';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import roleAdd from'./roleAdd.vue';

const roles = ref([]);
const isEdit = ref(false);
const role = ref({});
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
const addrole = ()=>{
    isEdit.value = true;
    role.value = false;
}
const roleEdit = (roleSelect)=>{
    isEdit.value = true;
    role.value = roleSelect;
}
const getRoles = ()=>{
    axios.get(`api/get-roles`).then((res)=>{
        roles.value = res.data.roles;
        notify(res.data.message);
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}
const goBack = (event)=>{
    isEdit.value = event;
    role.value = false;
    getRoles()
}
onMounted(()=>{
    getRoles();
})
const perUser = ref(JSON.parse(localStorage.getItem('perUser')));
const checkPermission = (page,per)=>{
    let permission = perUser.value.find(
        permission => permission.page.page === page
        && permission[per] === 1
    )
    if(permission){
        return true;
    }else{
        return false;
    }
}
</script>
<template>
    <div>
        <roleAdd v-if="isEdit" :role="role" @goBack="goBack($event)"/>
        <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-header">
                <h4 class="card-title">roles table</h4>
                <button v-if="checkPermission('roles','create')" class="btn btn-primary btn-circle bts-sm float-end" @click="addrole">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td v-if="checkPermission('roles','edit') || checkPermission('roles','delete')">Actions</td>
                                <td>id</td>
                                <td>name</td>
                            </tr>   
                        </thead>
                        <tfoot>

                        </tfoot>
                        <tbody>
                            <tr v-for="role in roles" :key="role.id">
                                <td v-if="checkPermission('roles','edit') || checkPermission('roles','delete')">
                                    <button v-if="checkPermission('roles','delete')" class="btn btn-danger btn-circle bts-sm m-1">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button v-if="checkPermission('roles','edit')" @click="roleEdit(role)" class="btn btn-info btn-circle bts-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                                <td>
                                    {{role.id}}
                                </td>
                                <td>
                                    {{role.name_role}}
                                </td>
                            </tr>                                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>