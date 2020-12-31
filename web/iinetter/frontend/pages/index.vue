<template>
  <div class="index">
    <div class="position-sticky">
      <div class="sticky-top border-bottom bg-white">
        <div class="p-2">
          <h1 class="m-0 h5 font-weight-bold">
            ホーム
          </h1>
        </div>
      </div>
      <div class="border-bottom tweetBox">
        <div class="m-2">
          <form class="form-group">
            <div class="row">
              <div class="col-12 my-2">
                <textarea
                  v-model="form.tweet_text"
                  :rows="tweetTextRows"
                  placeholder="いまどうしてる？"
                  class="form-control border-0 tweetTextbox"
                  style="resize: none"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <button type="button" class="btn rounded-circle tweetIconButton">
                  <font-awesome-icon :icon="['fas', 'image']" class="" />
                </button>
              </div>
              <div class="offset-4 col-4 text-center">
                <button
                  type="button"
                  class="btn rounded-pill font-weight-bold tweetButton"
                  :disabled="form.tweet_text.length === 0"
                  @click="create"
                >
                  ツイートする
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="timeline">
        <div v-for="tweet in tweets" :key="tweet.id" class="border-bottom">
          <Tweet :tweet-data="tweet" :refresh="refresh" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Tweet from '@/components/Tweet'

export default {
  components: {
    Tweet
  },
  async fetch () {
    const response = await this.$axios.get('/api/v1/tweets', {
      params: { ...this.$route.query }
    })
    this.tweets = response.data.data
  },
  data () {
    return {
      form: {
        tweet_type: 'tweet',
        tweet_text: ''
      },
      tweets: []
    }
  },
  computed: {
    tweetTextRows () {
      return this.form.tweet_text.split('\n').length
    }
  },
  methods: {
    async create () {
      const response = await this.$axios.post('/api/v1/tweets', this.form).catch(err => err.response)
      if (response.status !== 200) {
        const errors = Object.keys(response.data.errors).map(key => response.data.errors[key][0])
        alert(errors.join('\n'))
      }
      this.form.tweet_text = ''
      this.$fetch()
    },
    async update (tweetId, param) {
      const response = await this.$axios.patch('/api/v1/tweets/' + tweetId, param).catch(err => err.response)
      if (response.status !== 200) {
        const errors = Object.keys(response.data.errors).map(key => response.data.errors[key][0])
        alert(errors.join('\n'))
      }
    }
  }
}
</script>

<style scoped>
.tweetBox {
    border-width: 10px !important;
}
.tweetTextbox:focus {
    box-shadow: none;
    border: none;
}

.tweetButton {
  color: white;
  background: #1DA1F2
}

.tweetIconButton {
    border: none;
    width: 24px;
    height: 24px;
    padding: 0;
}
.tweetIconButton:focus {
    box-shadow: none;
}
.tweetIconButton:hover {
    color: #1DA1F2;
    background-color: rgba(#1DA1F2, 0.1);
}
</style>
