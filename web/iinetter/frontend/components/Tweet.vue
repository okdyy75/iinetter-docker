<template>
  <div v-if="!tweet" class="p-2">
    <!-- 削除除済みツイート -->
    <div class="row">
      <div class="small offset-1 mb-1 font-weight-bold text-secondary">
        このツイートは削除済みです
      </div>
    </div>
  </div>
  <div v-else class="p-2">
    <div v-if="tweetData.tweet_type === 'retweet'" class="row">
      <div class="small offset-1 mb-1 font-weight-bold text-secondary">
        <font-awesome-icon :icon="['fas', 'retweet']" />
        リツイート済み
      </div>
    </div>
    <div class="row">
      <div class="col-2 text-center">
        <img v-if="tweet.user.user_profile" :src="tweet.user.user_profile.icon_url" class="rounded-circle profileIcon">
        <img v-else src="http://localhost/images/user_icon_default.png" class="rounded-circle profileIcon">
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

        <!-- 引用リツイート -->
        <template v-if="tweet.tweet_type === 'retweet'">
          <div v-if="tweet.ref_tweet" class="my-2 p-2 border" style="border-radius: 16px;">
            <div class="row">
              <div class="col-2 text-center">
                <img v-if="tweet.user.user_profile" :src="tweet.user.user_profile.icon_url" class="rounded-circle profileIcon">
                <img v-else src="http://localhost/images/user_icon_default.png" class="rounded-circle profileIcon">
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
                <div class="mb-2" style="white-space: pre;" v-text="tweet.ref_tweet.tweet_text" />
              </div>
            </div>
          </div>
        </template>

        <div class="row">
          <div class="col-3">
            <button
              class="btn rounded-circle tweetButton"
            >
              <font-awesome-icon :icon="['far', 'comment']" class="" />
            </button>
            <span class="small">{{ tweet.reply_count }}</span>
          </div>
          <div class="col-3">
            <b-dropdown id="retweet_dropdown" dropup no-caret variant="outline">
              <template #button-content>
                <font-awesome-icon :icon="['fas', 'retweet']" class="" />
              </template>
              <b-dropdown-item @click="create({tweet_type: 'retweet', ref_tweet_id: tweet.id, tweet_text: ''})">
                リツイート
              </b-dropdown-item>
              <b-dropdown-item>引用リツイート</b-dropdown-item>
            </b-dropdown>
            <span class="small">{{ tweet.retweet_count }}</span>
          </div>
          <div class="col-3">
            <button
              class="btn rounded-circle tweetButton"
            >
              <font-awesome-icon :icon="['far', 'heart']" class="" />
            </button>
            <span class="small">{{ tweet.favorite_count }}</span>
          </div>
          <div class="col-3">
            <button class="btn rounded-circle tweetButton">
              <font-awesome-icon :icon="['fas', 'arrow-up']" class="" />
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    tweetData: {
      type: Object,
      required: true
    },
    refresh: {
      type: Function,
      required: true
    }
  },
  data () {
    return {
      tweet: null
    }
  },
  mounted () {
    // ただのリツイートはそれをツイート
    this.tweet = (this.tweetData.tweet_type === 'retweet' && !this.tweetData.tweet_text) ? this.tweetData.ref_tweet : this.tweetData
  },
  methods: {
    async create (params) {
      const response = await this.$axios.post('/api/v1/tweets', params).catch(err => err.response)
      if (response.status !== 200) {
        const errors = Object.keys(response.data.errors).map(key => response.data.errors[key][0])
        alert(errors.join('\n'))
      }
      this.refresh()
    }
  }
}
</script>

<style scoped>

.tweetButton, #retweet_dropdown /deep/ button {
    border: none;
    width: 24px;
    height: 24px;
    padding: 0;
}
.tweetButton:focus, #retweet_dropdown /deep/ button:focus {
    box-shadow: none;
}
.tweetButton:hover, #retweet_dropdown /deep/ button:hover {
    color: #1DA1F2;
    background-color: rgba(#1DA1F2, 0.1);
}

.profileIcon {
  width: 50px;
  height: 50px;
  object-fit: cover;
}

</style>
