export const state = () => ({
  tweetType: '',
  tweetText: '',
  refTweet: {},
  response: {}
})

export const mutations = {
  SET_TWEET_TYPE (state, data) {
    state.tweetType = data
  },
  SET_TWEET_TEXT (state, data) {
    state.tweetText = data
  },
  SET_REF_TWEET (state, data) {
    state.refTweet = data
  },
  SET_RESPONSE (state, data) {
    state.response = data
  }
}

export const actions = {
  async createTweet ({ commit, state }) {
    const params = {
      tweet_type: state.tweetType,
      tweet_text: state.tweetText
    }
    if (state.tweetType !== 'tweet') {
      params.ref_tweet_id = state.refTweet.id
    }
    const response = await this.$axios.post('/api/v1/tweets', params).catch(err => err.response)
    commit('SET_RESPONSE', response)
  }
}
