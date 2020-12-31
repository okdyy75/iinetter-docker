export const state = () => ({
  tweetType: '',
  tweetText: '',
  refTweet: {}
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
    if (response.status !== 200) {
      const errors = Object.keys(response.data.errors).map(key => response.data.errors[key][0])
      alert(errors.join('\n'))
    } else {
      commit('SET_TWEET_TYPE', '')
      commit('SET_TWEET_TEXT', '')
      commit('SET_REF_TWEET', {})
    }
  }
}
