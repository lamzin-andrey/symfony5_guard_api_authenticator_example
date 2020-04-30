<template>
	<div>
		<b-alert show dismissible>{{ $t('app.Yes') }}</b-alert>
		<div>
			<button class="btn btn-primary" @click="onClickDoIfConfirm">Confirm</button>
			<bootstrap4-confirm ref="confirmModal"></bootstrap4-confirm>
		</div>
	</div>
</template>
<script>
	export default {
		name: 'vueSPATraning',
		
		components:{
			'bootstrap4-confirm': require('../../../landlib/vue/2/bootstrap/4/bootstrap4confirm/bootstrap4Confirm').default
		},

		computed: {
			
		},

		
		//вызывается раньше чем mounted
		data: function(){return {
			/** @property {String} x */
			x: '',
		}; },
		//
		methods:{
			async onClickDoIfConfirm() {
				if (await this.$refs.confirmModal.confirm('You clicked the button.</p><p>Are you sure want show browser alert(0)?</p>')) {
					alert('Was click OK');
				} else {
					alert('Was click Cancel');
				}
				
			},
			

			
		},//end methods
		//вызывается после data, поля из data видны "напрямую" как this.fieldName
		mounted() {
			
		}
	}
</script>