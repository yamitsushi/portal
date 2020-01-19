const state = {
  count: 0
}

const getters = {
  amount : state => { return state.count },
  time : state => {
    var timer = state.count * 1800;

    var final = "";
    var temp = Math.floor(timer / 3600);
    if(temp > 1) final += temp + " Hours";
    else if(temp == 1) final += temp + " Hour";

    if(temp >= 1 && 1 <= (timer % 3600)) final += ", "

    var temp = Math.floor((timer % 3600) / 60);
    if(temp > 1) final += temp + " Minutes";
    else if(temp == 1) final += temp + " Minute";
    return final;
  }
}

const actions = {}

const mutations = {
  pulseIncrement (state) {
    state.count++
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
