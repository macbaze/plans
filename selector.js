var app = new Vue({
  el: '#vueContainer',
  data: {
  	currentStep: 0,
  	currentGroup: 0,
  	currentGroupName: '',
  	currentPlan: 0
  },
  methods: {
  	openGroup: function (event) {
            this.currentGroup = event.target.value;
            this.currentHeaderText = event.target.nextElementSibling.querySelector("h1").innerText;
            this.currentStep = 1;
        },
    openPlan: function (event) {
            this.currentPlan = event.target.value;
            this.currentStep = 2;

        },
    goBack: function (event) {
    	if (this.currentStep > 0)
    		this.currentStep--;
    	},
    choosePlan: function (event) {
    	document.forms.plan_selector.elements.chosenPlan.value = this.currentPlan;
    	alert('ID выбранного тарифа содержится в переменной \'chosenPlan\' формы \'plan_selector\'. ID = '
    		+document.forms.plan_selector.elements.chosenPlan.value);
    	}
  }
})