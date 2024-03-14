<script setup>
import { ref } from 'vue';
import { onMounted, inject, watchEffect } from '@vue/runtime-core';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import Paginate from 'vuejs-paginate-next';

const langs = ref([]);
const isAdd = ref(false);
const isEdit = ref(false);
const keyValue = ref("");
const search = ref("");
const page = ref(1);
const pageCount = ref(1);
const max = ref(3);
const errors = ref("");
const refForm = ref([
	{
		lang:"ar",
		value:"",
	},
	{
		lang:"fr",
		value:"",
	},
	{
		lang:"tr",
		value:"",
	},
	{
		lang:"en",
		value:"",
	},
]);

const addShow = ()=>{
	isAdd.value = !isAdd.value
	isEdit.value = false;
	getLangForm();
}
const getLangForm = ref([
	keyValue.value = "",
	refForm.value = [
		{
			lang:"ar",
			value:"",
		},
		{
			lang:"fr",
			value:"",
		},
		{
			lang:"tr",
			value:"",
		},
		{
			lang:"en",
			value:"",
		},
	]
]);

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

const getLangs = async (page = 1)=>{
    await axios.get(`api/langs?page=${page}&&search=${search.value}`).then((res)=>{
        langs.value = res.data.langs.data;
        pageCount.value = res.data.langs.last_page;
    }).catch((err)=>{
    })
}
const addLang = async ()=>{
    await axios.post(`api/add-langs`,{
    	refForm : refForm.value,
    	keyValue : keyValue.value,
    	isEdit : isEdit.value,
    }).then((res)=>{
    	console.log(res.data);
    	let message = res.data.messages;
    	isAdd.value = false;
		isEdit.value = false;
		getLangForm();
		getLangs();
		localStorage.setItem("messages","");
        axios.get(`api/get-i18n`).then((r)=>{
			localStorage.setItem("messages",JSON.stringify(r.data));
	    });
        notify(message);
    }).catch((err)=>{
    	errors.value = err;
    })
}
const editLang = (key)=>{
	isAdd.value = true;
	isEdit.value = true;
    axios.get(`api/langs/${key}`).then((res)=>{
        refForm.value = res.data.langs;
        keyValue.value = key;
        notify(res.data.message);
    }).catch((err)=>{
        notifyError(err.response.data.message);
    })
}
onMounted(async()=>{
    await getLangs(page.value);
})

const nextPage = () => {
  if (page.value < pageCount.value) {
    page.value++;
    getLangs(page.value);
  }
};

const prevPage = () => {
  if (page.value > 1) {
    page.value--;
    getLangs(page.value);
  }
};
</script>
<template>
	<div>
		<div class="demo-inline-spacing p-2">
		    <button class="btn btn-primary btn-relief-primary" @click="addShow">
		        {{isAdd ? $t("back") : $t("add")}}
		    </button>
		</div>
		<div v-if="isAdd">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">
								<span v-if="isEdit">
									{{$t("Edit setup")}}
								</span>
								<span v-else>
									{{$t("Add settings")}}
								</span>
							</h4>
						</div>
					</div>
				</div>
			</div>
			<div class="card-body">
				<hr/>
				<div class="row">
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>{{$t("key")}}</label>
						<input type="text" v-model="keyValue" class="form-control form-control-page" placeholder="keyValue">
					</div>
				</div>
				<div class="row" v-for="(lang,index) in refForm" :key="index">
					<div class="col-sm-6 mb-3 mb-sm-0">
						<label>{{lang.lang}}</label>
						<input type="text" v-model="lang.value" class="form-control form-control-page" placeholder="keyValue">
					</div>
				</div>
				<div class="col-sm-6 mb-3 mb-sm-0">
					<a @click="addLang()" class="btn btn-primary btn-role btn-block">
						{{isEdit ? 'update' : 'create'}}
					</a> 
				</div>
			</div>
		</div>
		<div v-if="!isAdd" class="row" id=table-head>
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">{{$t("Table")}} {{$t("langs")}}</h4>
						<h4 class="card-title">
							<input class="form-control" v-model="search" @input="(getLangs(page))" placeholder="search">
						</h4>
					</div>
					<div class="table-responsive">
						<table class="table">
							<thead class="table-dark">
								<tr>
									<th>{{$t("language")}}</th>
									<th>{{$t("key")}}</th>
									<th>{{$t("value")}}</th>
									<th>{{$t("Actions")}}</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(lang,index) in langs" :key="index">
									<td>{{lang.lang}}</td>
									<td>{{lang.key}}</td>
									<td>{{lang.value}}</td>
									<td>
										<div class="d-flex">
											<button class="btn btn-primary btn-sm" @click="editLang(lang.key)">
												<i class="fa fa-edit"></i>
											</button>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<!--<Paginate>
							v-model="page" 
							@click="getLangs(page)" 
							:page-count="pageCount"
						 	:page-range="max"
						 	:prev-text="$t('next')"
						 	:next-text="$t('next')"
						 	:container-class="pagination"
						</Paginate>-->
						 <!-- Pagination controls -->
					    <div class="pagination">
					      <button @click="prevPage" class="mr-2 btn btn-primary" :disabled="page === 1">Previous</button>
					      	<span>{{ page }} / {{ pageCount }}</span>
					      <button @click="nextPage" class="ml-2 btn btn-primary" :disabled="page === pageCount">Next</button>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>