import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        token: ''
    },
    mutations: {
	    increment (state) {
	      state.count++
	    }
  },
  actions: {
	    increment (context) {
            axios
                .post("http://localhost:8080/oauth/v2/token",{
                    grant_type: 'password',
                    client_id: 'new name',
                    username: 'user',
                    password: 'test',

                })
                .then((response) => {
                    let data = response.data;
                    console.log(response);
                    for (let key in data) {
                        this.items.push({
                            isActive: true,
                            'raison_sociale' : data[key].entreprise.raison_sociale,
                            'jour' : data[key].day_variance,
                            'semaine' : data[key].week_variance,
                            'mois' : data[key].month_variance,
                            'trimestre' : data[key].trimester_variance,
                            'annee' : data[key].year_variance,
                            'cinq_ans' : data[key].five_year_variance,
                            'dix_ans' : data[key].ten_year_variance,
                            'code' : data[key].entreprise.code
                        })
                    }
                })
                .catch(function (error) {
                    console.log(error);
                })
	    }
  }
});