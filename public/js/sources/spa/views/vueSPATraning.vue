<template>
	<div>
		<b-alert show dismissible>{{ $t('app.Yes') }}</b-alert>
		<div>
			<b-button v-b-modal.modal-1>Launch demo modal</b-button>

			<b-modal id="modal-1" title="BootstrapVue" @cancel="onClickCancelButton">
				<p class="my-4">Hello from modal!</p>
			</b-modal>
		</div>
	</div>
</template>
<script>
	export default {
		name: 'vueSPATraning',
		
		components:{
		},

		//Аргументы (html атрибуты) извне
		props:{

		},
		//вызывается раньше чем mounted
		data: function(){return {
			/** @property {*} isCurrentSchemeModify */
			//isCurrentSchemeModify: false,
		}; },
		//
		methods:{
			/**
			 * @description Обработка клика на кнопке Отмена
			*/
			onClickCancelButton(){
				alert('Hello!');
			},
			
		},//end methods
		//вызывается после data, поля из data видны "напрямую" как this.fieldName
		mounted() {
		}
	}
</script>