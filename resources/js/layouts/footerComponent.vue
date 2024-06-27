<script setup>
import { ref } from 'vue';
const setting = JSON.parse(localStorage.getItem('setting'));
</script>
<template>
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; {{setting.name}}</span>
            </div>
        </div>
    </footer>
</template>
