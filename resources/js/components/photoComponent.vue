<script setup>
import { ref } from 'vue';
import { Cropper } from 'vue-advanced-cropper';
import { watchEffect } from '@vue/runtime-core';
import 'vue-advanced-cropper/dist/style.css';
const emit = defineEmits(["isEmit"]);
const props = defineProps(["result"]);

const image = ref("");
const img = ref("");
const show = ref(false);
const change = ({coordinates,canvas}) => {
    image.value = canvas.toDataURL();
    show.value = true;
}
const uploadFile = (e) => {
 var reader,
 files = e.target.files;
 reader = new FileReader();
 reader.onload = (e) => {
    img.value = e.target.result;
 };
 reader.readAsDataURL(files[0]);
};
const SubmitFile = () => {
    if (image.value === '') {
        alert('Please select image');
        return;
    }
    var arr = image.value.split(","),
    mime = arr[0].match(/:(.*?);/)[1],
    bstr = atob(arr[1]),
    n = bstr.length,
    u8arr = new Uint8Array(n);
    while(n--){
        u8arr[n] = bstr.charCodeAt(n);
    }
    var file = new File([u8arr],"filename.jpg",{type:mime});
    emit("isEmit",file);
}
watchEffect(()=>{
    if (props.result) {
        image.value = '';
        img.value = '';
    }
    // if (img.value !== "") {
    //     show.value = true;
    // }
});
</script>
<template>
    <div style="width: 350px;margin-top: 100px;">
        <button class="btn btn-primary" @click="SubmitFile">save</button>
        <div style="width: 400px;">
            <img :src="image" style="width: 200px;">
            <cropper class="croppper" :src="img" :stencil-props="{aspectRation:10/10}" @change="change"></cropper>
        </div>
        <div class="input-group">
            <input type="file" class="form-control" placeholder="Upload Image" @change="uploadFile" ref="file">
        </div>
    </div>
</template>