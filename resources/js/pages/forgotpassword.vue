<script setup>
import { ref } from '@vue/reactivity';

const email = ref("");
const loading = ref(false);
const sent = ref(false);

const resetPassword =()=>{
    if (email.value === "") {
        alert('Please fill all fields')
    } 
    else{
        loading.value = true
        axios.post('api/reset-password',{
        email: email.value,
        }).then((res)=>{
            loading.value = false
            sent.value = true
            alert(res.data.message)
        }).catch((err)=>{
            console.log(err);
        })
    }
}
</script>
<template>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div v-if="!sent" class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user">
                                        <div v-if="!loading" class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" v-model="email"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <a v-if="!loading" @click="resetPassword()" class="btn btn-primary btn-user btn-block">
                                            Reset Password
                                        </a>
                                        <a v-if="loading" class="btn btn-danger btn-user btn-block">
                                            Waiting........
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="/register">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="/login">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="sent" class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-success mb-2">Send Link</h1>
                                        <p class="mb-4">Send you a link to reset your password</p>
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="/register">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="/login">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>