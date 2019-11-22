import axios from 'axios';

export default {
  state: {
    data: [],
    result: null
  },
  mutations: {
    getProjects(state, next = null) {
      axios.get(window.endpoint + "projects/all", this.state.auth.header)
          .then((response) => {
            state.data = response.data;
            // console.log(response.data);

            if(next) next();
          })
    },

    getProject(state, id) {
      state.result = state.data.find(project => project.id === parseInt(id));
    }
  }
};
