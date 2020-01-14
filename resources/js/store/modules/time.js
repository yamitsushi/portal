const state = {
  seconds: 3610
}

const getters = {
  seconds : state => { return state.seconds },
  timer : state => {
    var timer = state.seconds;

    var final = "";

    var temp = Math.floor(timer % 60);
    if(temp > 1) final = temp + " Seconds" + final;
    else if(temp == 1) final = temp + " Second" + final;

    timer = Math.floor(timer / 60);
    if(timer > 0 && temp > 0) final = ", " + final;

    var temp = Math.floor(timer % 60);
    if(temp > 1) final = temp + " Minutes" + final;
    else if(temp == 1) final = temp + " Minute" + final;

    timer = Math.floor(timer / 60);
    if(timer > 0 && temp > 0) final = ", " + final;

    var temp = Math.floor(timer % 60);
    if(temp > 1) final = temp + " Hours" + final;
    else if(temp == 1) final = temp + " Hour" + final;

    return final;
  }
}

const actions = {}

const mutations = {
  decreaseTime (state) {
    state.seconds--;
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
