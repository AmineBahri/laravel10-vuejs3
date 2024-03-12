<script setup>
import { ref } from 'vue';
import { onMounted } from '@vue/runtime-core';
import axios from 'axios';
import { toast } from 'vue3-toastify';

const permissions = ref([]);
const isEdit = ref(false);
const permission = ref({});
const role_id = ref(0);
const roles = ref([]);
const pages = ref([]);

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

const getRoles = ()=>{
    axios.get(`api/get-roles`).then((res)=>{
        roles.value = res.data.roles;
        notify(res.data.message);
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}

const getPages = ()=>{
    axios.get(`api/get-pages`).then((res)=>{
        pages.value = res.data.pages;
        notify(res.data.message);
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}

const getPermission = (page_id,role_id,per)=>{
    let permission = permissions.value.find(
        permission => permission.page_id === page_id 
        && permission.role_id === role_id 
        && permission[per] === 1
    )
    if(permission){
        return true;
    }else{
        return false;
    }
}

const updatePermission = (page_id,role_id,permission,event)=>{
    if(role_id === 0){
        notifyError("please select a role");
        return false;
    }
    axios.post(`api/update-permission`,{
        page_id:page_id,
        role_id:role_id,
        permission:permission,
        event:event
    }).then((res)=>{
        if(res.data.status === 401){
            notifyError(res.data.message);
            return false;
        }
        notify(res.data.message);
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}
const getPermissions = ()=>{
    axios.get(`api/get-permissions/${role_id.value}`).then((res)=>{
        permissions.value = res.data.permissions;
        notify(res.data.message);
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}

onMounted(async ()=>{
    await getRoles();
    await getPages();
    await getPermissions();
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
        <div v-if="!isEdit" class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-header">
                <h4 class="card-title">permissions table</h4>
                <h4 class="card-title">
                    <select v-model="role_id" class="form-select" @change="getPermissions()">
                        <option value="0">select role</option>
                        <option v-for="role in roles" :key="role.id" :value="role.id">{{role.name_role}}</option>
                    </select>
                </h4>
                <button class="btn btn-primary btn-circle bts-sm float-end" @click="addpermission">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table v-if="role_id!=0" class="table table-bordered text-center" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <td>page</td>
                                <td>read</td>
                                <td>edit</td>
                                <td>create</td>
                                <td>update</td>
                                <td>delete</td>
                            </tr>   
                        </thead>
                        <tfoot>

                        </tfoot>
                        <tbody>
                            <tr v-for="page in pages" :key="page.id">
                                <td>
                                    {{page.page}}
                                </td>
                                <td>
                                    <input type="checkbox"
                                    :disabled="!checkPermission('permissions','update')"
                                    :checked="getPermission(page.id,role_id,'read')"
                                    @change="updatePermission(page.id,role_id,'read',$event.target.checked)"
                                    >
                                </td>
                                <td>
                                    <input type="checkbox" 
                                    :disabled="!checkPermission('permissions','update')"
                                    :checked="getPermission(page.id,role_id,'edit')"
                                    @change="updatePermission(page.id,role_id,'edit',$event.target.checked)"
                                    >
                                </td>
                                <td>
                                    <input type="checkbox"
                                    :disabled="!checkPermission('permissions','update')"
                                    :checked="getPermission(page.id,role_id,'create')"
                                    @change="updatePermission(page.id,role_id,'create',$event.target.checked)"
                                    >
                                </td>
                                <td>
                                    <input type="checkbox" 
                                    :disabled="!checkPermission('permissions','update')"
                                    :checked="getPermission(page.id,role_id,'update')"
                                    @change="updatePermission(page.id,role_id,'update',$event.target.checked)"
                                    >
                                </td>
                                <td>
                                    <input type="checkbox"
                                    :disabled="!checkPermission('permissions','update')"
                                    :checked="getPermission(page.id,role_id,'delete')"
                                    @change="updatePermission(page.id,role_id,'delete',$event.target.checked)"
                                    >
                                </td>
                            </tr>                                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>