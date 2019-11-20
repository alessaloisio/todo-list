export default (to, from, next) => {

    if(!localStorage.getItem('auth_token')){
        next();
        return;
    }

    next({ name: 'Home' })
};
