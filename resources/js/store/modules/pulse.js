const state = {
  count: 0
}

const getters = {
  amount : state => { return state.count },
  time : state => {
    var left = state.count;
    var timer = 0;
    timer += Math.floor(left / 10) * 60;
    left = left % 10;
    timer += Math.floor(left / 5) * 30;
    left = left % 5;
    timer += left * 5;

    var final = "";
    var temp = Math.floor(timer / 60);
    if(temp > 1) final += temp + " Hours";
    else if(temp == 1) final += temp + " Hour";

    if(temp >= 1 & (timer % 60) > 0) final += ", "

    var temp = timer % 60;
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
