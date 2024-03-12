<script setup>
import { ref } from '@vue/reactivity';
import { toast } from 'vue3-toastify';
import { watchEffect,onMounted } from '@vue/runtime-core';

const emit = defineEmits(['goBack']);
const props = defineProps(['user']);
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
const id = ref("");
const name = ref("");
const father_name = ref("");
const gender = ref("");
const genders = ref([
	{type:"male"},
	{type:"female"},
]);
const date_of_birth = ref("");
const mobile = ref("");
const email = ref("");
const password = ref("");
const password_confirmation = ref("");
const roles = ref([]);
const role_id = ref("");
const getRoles = (()=>{
   axios.get('api/get-roles').then((res)=>{
        roles.value = res.data.roles;
    }); 
});
const confirmPass =()=>{
    if (password.value !== password_confirmation.value) {
        alert('Password does not match')
    } 
}
onMounted(async ()=>{
    await getRoles();
})
const createUser =()=>{
    if ( (name.value ==='' || email.value==='' || password.value ==='' || password_confirmation.value==='') && !props.user) {
        alert('Please fill all fields')
    } 
    if ( name.value ==='' || email.value==='') {
        alert('Please fill all fields')
    }    
    else {
        axios.post('api/create-user',{
        id: id.value,
        name: name.value,
        father_name: father_name.value,
        date_of_birth: date_of_birth.value,
        mobile: mobile.value,
        gender: gender.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value,
        role_id: role_id.value
        }).then((res)=>{
        	notify(res.data.message);
        	emit('goBack',false);
            id.value = ''
        	name.value = ''
        	father_name.value  = ''
        	date_of_birth.value  = ''
        	mobile.value  = ''
    		gender.value  = ''
        	email.value  = ''
        	password.value  = ''
        	password_confirmation.value  = ''
            role_id.value  = ''
        }).catch((err)=>{
        	notifyError(err.response.data.message);
        })
    }
}
const goBack = ()=>{
    emit('goBack',false);
    name.value = ''
	father_name.value  = ''
	date_of_birth.value  = ''
	mobile.value  = ''
	gender.value  = ''
	email.value  = ''
	password.value  = ''
	password_confirmation.value  = ''
    role_id.value  = ''
}
watchEffect(()=>{
    if (props.user) {
        id.value = props.user.id
        name.value = props.user.name
        father_name.value  = props.user.father_name
        date_of_birth.value  = props.user.date_of_birth
        mobile.value  = props.user.mobile
        gender.value  = props.user.gender
        email.value  = props.user.email
        role_id.value  = props.user.role_id
    }
})
</script>
<template>
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">
                                 {{props.user ? 'Update an Account!' : 'Create an Account!'}} 
                                </h1>
                            </div>
                            <form class="user">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="name" class="form-control form-control-user" id="exampleFirstName"
                                            placeholder="First Name">
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" v-model="father_name" class="form-control form-control-user" id="examplefather_name"
                                            placeholder="Father Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                	<div class="col-sm-4 mb-3 mb-sm-0">
                                        <select class="form-control" v-model="gender">
                                        	<option v-for="gender in genders" :key="gender.type" :value="gender.type">
                                        		{{gender.type}}
                                        	</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <select class="form-control" v-model="role_id">
                                            <option v-for="role in roles" :key="role.id" :value="role.id">
                                                {{role.name_role}}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <input type="number" v-model="date_of_birth" class="form-control form-control-user" id="exampledate_of_birth"
                                            placeholder="date_of_birth">
                                    </div>
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <input type="number" v-model="mobile" class="form-control form-control-user" id="examplemobile"
                                            placeholder="mobile">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" v-model="email" class="form-control form-control-user" id="exampleInputEmail"
                                        placeholder="Email Address">
                                </div>
                                <div v-if="!props.user" class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" v-model="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" @change="confirmPass()" v-model="password_confirmation" class="form-control form-control-user"
                                            id="exampleRepeatPassword" placeholder="Repeat Password">
                                    </div>
                                </div>
                                <a @click="createUser()" class="btn btn-primary btn-user btn-block">
                                    {{props.user ? 'update' : 'create User'}} 
                                </a>
                                <a @click="goBack()" class="btn btn-info btn-user btn-block">
                                    Back
                                </a>                                
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>