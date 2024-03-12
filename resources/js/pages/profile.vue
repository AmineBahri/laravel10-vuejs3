<script setup>
import { ref } from '@vue/reactivity';
import PhotoComponent from '../components/photoComponent.vue';
import { toast } from 'vue3-toastify';

const props = defineProps(["user"]);
const result = ref(false);
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
const userUpdate =()=>{
    if ( props.user.name === '' || props.user.email === '') {
        notifyError('Please fill all fields')
    } else {
        axios.post('api/user-update',{
        name: props.user.name,
        father_name: props.user.father_name ,
        email: props.user.email ,
        mobile: props.user.mobile ,
        date_of_birth: props.user.date_of_birth ,
        }).then((res)=>{
            notify(res.data.message)
        }).catch((err)=>{
            notifyError(err.response.data.message);
        })
    }
}
const submitFile = (file) => {
    result.value = true
    let formData = new FormData();
    formData.append('file',file);
    formData.append('id',props.user.id);
    axios.post('api/profile-uplaod',formData,{
        headers:{
            'Content-Type':'multipart/form-data'
        }
    }).then((res)=>{
        result.value = true
        props.user.photo = res.data.path
        notify(res.data.message);
    }).catch((err)=>{
        result.value = false
        notifyError(err.res.data.message);
    })
}

const deletePhoto = (id) => {
    axios.post('api/delete-photo',{
        id:id
    }).then((res)=>{
        notify(res.data.message);
        window.location.reload();
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}

const selectPhoto = (id) => {
    axios.post('api/select-photo',{
        id:id
    }).then((res)=>{
        notify(res.data.message);
        window.location.reload();
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}
</script>
<template>
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-profile-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Profile</h1>
                            </div>
                            <form class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="props.user.name" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="First Name">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="props.user.father_name" class="form-control form-control-user" id="exampleFatherName"
                                            placeholder="Father Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" v-model="props.user.date_of_birth" class="form-control form-control-user" id="exampledate_of_birth"
                                            placeholder="date_of_birth">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="number" v-model="props.user.mobile" class="form-control form-control-user" id="exampleMobile"
                                            placeholder="Mobile">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" v-model="props.user.email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address">
                                </div>
                                <a @click="userUpdate()" class="btn btn-primary btn-user btn-block">
                                    update
                                </a>                                
                            </form>
                            <hr>
                            <div class="text-center">
                                <router-link class="small" to="/reset-password-form-sent">
                                    change password
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card pb-5">
                            <PhotoComponent class="m-auto" @isEmit="submitFile($event)" :result="result"></PhotoComponent>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td>operations</td>
                                            <td>photo</td>
                                        </tr>   
                                    </thead>
                                    <tfoot>

                                    </tfoot>
                                    <tbody>
                                        <tr v-for="photo in props.user.photos" :key="photo.id">
                                            <td>
                                                <button v-if="photo.photo != props.user.photo" @click="deletePhoto(photo.id)" class="btn btn-danger btn-circle bts-sm m-1">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <button v-if="photo.photo != props.user.photo" @click="selectPhoto(photo.id)" class="btn btn-info btn-circle bts-sm">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                            <td>
                                                <img :src="'/images/user/'+photo.photo" class="img-fluid rounded circle" alt="avatar" width="40" height="40"/>
                                            </td>
                                        </tr>                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>