<template>
  <div class="index">
    <div class="position-sticky">
      <div class="sticky-top border-bottom bg-white">
        <div class="m-2">
          <h1 class="h5 font-weight-bold">
            ホーム
          </h1>
        </div>
      </div>
      <div class="border-bottom tweet-box">
        <div class="m-2">
          <form class="form-group">
            <div class="row">
              <div class="col-12 my-2">
                <textarea
                  v-model="form.tweet_text"
                  :rows="tweetTextRows"
                  placeholder="いまどうしてる？"
                  class="form-control border-0 tweet-textbox"
                  style="resize: none"
                />
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <button type="button" class="btn rounded-circle tweet-btn">
                  <font-awesome-icon :icon="['fas', 'image']" class="" />
                </button>
              </div>
              <div class="offset-4 col-4 text-center">
                <button
                  type="button"
                  class="btn rounded-pill font-weight-bold"
                  style="color: white;background: #1DA1F2"
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
        <div v-for="(tweet, index) in tweets" :key="index" class="border-bottom">
          <div class="p-2">
            <div class="row">
              <div class="col-2 text-center">
                <template v-if="tweet.user.user_profile && tweet.user.user_profile.icon">
                  <img :src="'http://localhost/storage/' + tweet.user.user_profile.icon" class="rounded-circle profile-icon">
                </template>
                <template v-else>
                  <img :src="'http://placehold.jp/20/FFFFFF/333333/100x100.png?text=' + tweet.user.name" class="rounded-circle profile-icon" style="border: 1px solid #555555;">
                </template>
              </div>
              <div class="col-10 pl-0">
                <div>
                  <nuxt-link :to="'/'+tweet.user.name">
                    {{ tweet.user.name }}
                  </nuxt-link>
                  <span v-if="tweet.user.user_profile && tweet.user.user_profile.screen_name">
                    @{{ tweet.user.user_profile.screen_name }}
                  </span>
                </div>
                <div class="mb-2" style="white-space: pre;" v-text="tweet.tweet_text" />
                <div class="row">
                  <div class="col-3">
                    <button
                      class="btn rounded-circle tweet-btn"
                      @click="tweet.reply_count++; update(tweet.id, {reply_count: tweet.reply_count})"
                    >
                      <font-awesome-icon :icon="['far', 'comment']" class="" />
                    </button>
                    <span class="small">{{ tweet.reply_count }}</span>
                  </div>
                  <div class="col-3">
                    <button
                      class="btn rounded-circle tweet-btn"
                      @click="tweet.retweet_count++; update(tweet.id, {retweet_count: tweet.retweet_count})"
                    >
                      <font-awesome-icon :icon="['fas', 'retweet']" class="" />
                    </button>
                    <span class="small">{{ tweet.retweet_count }}</span>
                  </div>
                  <div class="col-3">
                    <button
                      class="btn rounded-circle tweet-btn"
                      @click="tweet.favorite_count++; update(tweet.id, {favorite_count: tweet.favorite_count})"
                    >
                      <font-awesome-icon :icon="['far', 'heart']" class="" />
                    </button>
                    <span class="small">{{ tweet.favorite_count }}</span>
                  </div>
                  <div class="col-3">
                    <button class="btn rounded-circle tweet-btn">
                      <font-awesome-icon :icon="['fas', 'arrow-up']" class="" />
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  async fetch () {
    const response = await this.$axios.get('/api/v1/tweets')
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

.tweet-box {
    border-width: 10px !important;
}
.tweet-textbox:focus {
    box-shadow: none;
    border: none;
}

.tweet-btn {
    border: none;
    width: 24px;
    height: 24px;
    padding: 0;
}
.tweet-btn:focus {
    box-shadow: none;
}
.tweet-btn:hover {
    color: #1DA1F2;
    background-color: rgba(#1DA1F2, 0.1);
}

.profile-icon {
  width: 50px;
  height: 50px;
  object-fit: cover;
}

</style>
