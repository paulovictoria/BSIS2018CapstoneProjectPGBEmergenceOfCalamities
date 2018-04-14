<template>
  <div class="md-layout md-alignment-space-around-space-around md-layout--padding body-padding">
    <div class="md-layout-item md-large-size-65 md-medium-size-50 md-small-size-100">
      <p class="md-headline mdl-typography--text-center">Dam Reports</p>
        <chartjs-line :datasets="datasets" 
                      :bind="true" 
                      :labels="labels"></chartjs-line>
    </div>
    <div class="md-layout-item md-large-size-35 md-medium-size-50 md-small-size-100">
			<div class="button__holder">
				<md-button class="md-fab md-primary"
									@click="showModal">
        	<md-icon>add</md-icon>
      	</md-button>
			</div>
           <div class="md-layout md-alignment-space-around-center">
             <div class="md-layout-item md-size-100">
               <p class="md-headline mdl-typography--text-center">
                 Angat Dam
               </p>
               <p class="md-display-2 mdl-typography--text-center">
                 {{datasets[0].data.slice(-1).toString()}} M 
               </p>
               <p class="md-caption mdl-typography--text-center">
                 As of {{labels.slice(-1).toString()}}
               </p>
               <p class="md-caption mdl-typography--text-center">
                 Normal Water Level - 212.00 meters
               </p>
             </div>
               <div class="md-layout-item md-size-100">
               <p class="md-headline mdl-typography--text-center">
                 Ipo Dam
               </p>
              <p class="md-display-2 mdl-typography--text-center">
                 {{datasets[1].data.slice(-1).toString()}} M 
               </p>
               <p class="md-caption mdl-typography--text-center">
                 As of {{labels.slice(-1).toString()}}
               </p>
               <p class="md-caption mdl-typography--text-center">
                 Spilling Level - 101.00 meters
               </p>
             </div>
             <div class="md-layout-item md-size-100">
               <p class="md-headline mdl-typography--text-center">
                 Bustos Dam
               </p>
                <p class="md-display-2 mdl-typography--text-center">
                 {{datasets[2].data.slice(-1).toString()}} M 
               </p>
               <p class="md-caption mdl-typography--text-center">
                 As of {{labels.slice(-1).toString()}}
               </p>
               <p class="md-caption mdl-typography--text-center">
                 Spilling Level - 17.70 meters
               </p>
             </div>
           </div>
    </div>
		<sweet-modal ref="modal" width="400">
			<div class="md-layout md-alignment-center">
				<div class="md-layout-item md-size-50">
					<p class="md-headline">Enter the dam amount:</p>
					<md-field>
						<md-input v-model="damInput" 
											:required="true"
											type="number"
											@keyup.enter="submitData"
											name="amount"></md-input>
						<span class="md-helper-text">in Meters</span>
					</md-field>
				</div>
			</div>			
		</sweet-modal>
  </div>
</template>

<script>
export default {
  name: 'Dams',
  props: {

  },
  data() {
    return {
      damInput: '',
      src: {
        blue: 'images/bluedam.png',
        orange: 'images/bluedam.png',
        green: 'images/bluedam.png',
      },
			labels: [],
			datasets: [
				{
            label: 'ANGAT',
            data: [],
            backgroundColor: [
                'rgba(33, 150, 243, 0.2)',
                'rgba(33, 150, 243, 0.2)',
                'rgba(33, 150, 243, 0.2)',
                'rgba(33, 150, 243, 0.2)',
                'rgba(33, 150, 243, 0.2)',
								'rgba(33, 150, 243, 0.2)',
            ],
            borderColor: [
                	'rgba(33, 150, 243, 1)',
                	'rgba(33, 150, 243, 1)',
                	'rgba(33, 150, 243, 1)',
                	'rgba(33, 150, 243, 1)',
                	'rgba(33, 150, 243, 1)',
									'rgba(33, 150, 243, 1)'
									],
            borderWidth: 1
        },
        {
            label: 'IPO',
            data: [],
            backgroundColor: [
                'rgba(76,175,80,0.2)',
                'rgba(76,175,80,0.2)',
                'rgba(76,175,80,0.2)',
                'rgba(76,175,80,0.2)',
                'rgba(76,175,80,0.2)',
                'rgba(76,175,80,0.2)'
            ],
            borderColor: [
                'rgba(76,175,80,1)',
                'rgba(76,175,80,1)',
                'rgba(76,175,80,1)',
                'rgba(76,175,80,1)',
                'rgba(76,175,80,1)',
                'rgba(76,175,80,1)'
            ],
            borderWidth: 1
        },
        {
            label: 'BUSTOS',
            data: [],
            backgroundColor: [
                'rgba(255,152,0,0.2)',
                'rgba(255,152,0,0.2)',
                'rgba(255,152,0,0.2)',
                'rgba(255,152,0,0.2)',
                'rgba(255,152,0,0.2)',
                'rgba(255,152,0,0.2)'
            ],
            borderColor: [
                'rgba(255,152,0,1)',
                'rgba(255,152,0,1)',
                'rgba(255,152,0,1)',
                'rgba(255,152,0,1)',
                'rgba(255,152,0,1)',
                'rgba(255,152,0,1)'
            ],
            borderWidth: 1
				}
				],
			angat: {
					damHeight: '',
					damTime: ''
				},
			ipo: {
					damHeight: '',
					damTime: ''
				},
			bustos: {
					damHeight: '',
					damTime: ''
				},
			}

    },
    methods: {
      showModal(){
				this.$refs.modal.open();
			},
			submitData() {
				this.$http.post('/dams/add', {
					amount: this.damInput
				}, {
					headers: {
						'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
					}
				}).then(response => {
					if(response.status == 200) {
						this.$refs.modal.close();
						this.datasets[0].data = [];
						this.datasets[1].data = [];
						this.datasets[2].data = [];
						this.fetchResults();
					}
				}).catch(response => {
					console.log(response)
				});
				this.damInput = ''
			},
			iterateIt(theData, num) {
				const result = theData.data
				result.map(res => {
					res.updates.map(x => {
						this.labels.push(x.updated_at);
						this.datasets[num].data.push(x.amount);
					});
				});
		},
		fetchResults() {	
					axios.all([
			axios.get('/dams/status/ipo'),
			axios.get('/dams/status/angat'),
			axios.get('/dams/status/bustos')])
				.then(axios.spread((ipo, angat, bustos) => {
					this.iterateIt(angat, 0);
					this.iterateIt(ipo, 1);
					this.iterateIt(bustos, 2);
				}));
		}
		
		},
		mounted() {
			this.fetchResults();
		},
  }
</script>

<style lang="scss" scoped>
.md-image__responsive  {
  width: 100%;
  height: 100%;
}

.md-layout--padding {
	padding: 15px;
}

.button__holder {
	width: 70px;
	max-width: 100%;
	position: absolute;
	right: 0;
}

</style>