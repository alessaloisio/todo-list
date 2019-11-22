export default (error) => {
  if(error.response){

    const data = error.response.data;
    const result = {};

    for (let key in data) {
      if (!data.hasOwnProperty(key)) continue;

      let obj = data[key];
      result[key] = obj.toString();
    }

    return result;
  }
};
