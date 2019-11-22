export default {
  state: {
    authenticate: false,
    header: { params:{}, headers: { 'Authorization': null } }
  },
  mutations: {
    authenticate (state) {

      if(localStorage.getItem('auth_token'))
        state.header.headers['Authorization'] = localStorage.getItem('auth_token')
      else state.header.headers['Authorization'] = null;

      state.authenticate = !state.authenticate;
    }
  }
};
