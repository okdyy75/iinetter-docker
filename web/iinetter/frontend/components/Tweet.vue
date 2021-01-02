<template>
  <div v-if="tweet" :class="injectClass">
    <div class="p-2">
      <div v-if="tweetData.tweet_type === 'retweet'" class="row">
        <div class="small offset-1 mb-1 font-weight-bold text-secondary">
          <font-awesome-icon :icon="['fas', 'retweet']" />
          リツイート済み
        </div>
      </div>
      <div :id="'tweet-id-'+tweet.id" class="row">
        <div class="col-2 text-center">
          <img v-if="tweet.user.user_profile" :src="tweet.user.user_profile.icon_url" class="rounded-circle profileIcon">
          <img v-else src="http://localhost/images/user_icon_default.png" class="rounded-circle profileIcon">
        </div>
        <div :class="['col-10', nestLevel === 1 ? 'pl-0' : '']">
          <div class="d-flex">
            <div>
              <nuxt-link :to="'/'+tweet.user.name">
                {{ tweet.user.name }}
              </nuxt-link>
              <span v-if="tweet.user.user_profile && tweet.user.user_profile.screen_name">
                @{{ tweet.user.user_profile.screen_name }}
              </span>
            </div>
            <div class="mx-auto" />
            <div v-if="nestLevel === 1">
              <b-dropdown id="tweet_other_dropdown" dropup no-caret variant="outline">
                <template #button-content>
                  <font-awesome-icon :icon="['fas', 'ellipsis-h']" class="" />
                </template>
                <b-dropdown-item @click="tweetDelete(tweetData.id)">
                  削除
                </b-dropdown-item>
              </b-dropdown>
            </div>
          </div>
          <div v-if="tweetData.tweet_type === 'reply' && tweet.ref_tweet">
            <nuxt-link :to="'/' + tweet.ref_tweet.user.name + '#tweet-id-'+tweet.ref_tweet.id">
              <div class="small">
                RE：{{ tweet.user.name }}
                <span v-if="tweet.user.user_profile && tweet.user.user_profile.screen_name">
                  @{{ tweet.user.user_profile.screen_name }}
                </span>
              </div>
            </nuxt-link>
          </div>
          <div class="mb-2" style="white-space: pre-wrap;" v-text="tweet.tweet_text" />

          <!-- 引用リツイート -->
          <template v-if="tweet.tweet_type === 'retweet' && nestLevel === 1">
            <div v-if="tweet.ref_tweet" class="my-2 p-2 border" style="border-radius: 16px;">
              <Tweet :tweet-data="tweet.ref_tweet" :nest-level="nestLevel + 1" />
            </div>
          </template>

          <div v-if="nestLevel === 1" class="row">
            <div class="col-3">
              <button
                class="btn rounded-circle tweetIconButton"
                @click="replyClick(tweet)"
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
                <b-dropdown-item @click="reTweetClick(tweet)">
                  リツイート
                </b-dropdown-item>
                <b-dropdown-item @click="refReTweetClick(tweet)">
                  引用リツイート
                </b-dropdown-item>
              </b-dropdown>
              <span class="small">{{ tweet.retweet_count }}</span>
            </div>
            <div class="col-3">
              <button
                class="btn rounded-circle tweetIconButton"
              >
                <font-awesome-icon :icon="['far', 'heart']" class="" @click="() => { if ($auth.loggedIn) tweet.favorite_count++;tweetUpdate(tweet.id, tweet.favorite_count) }" />
              </button>
              <span class="small">{{ tweet.favorite_count }}</span>
            </div>
            <div class="col-3">
              <button class="btn rounded-circle tweetIconButton">
                <font-awesome-icon :icon="['fas', 'arrow-up']" class="" @click="tweetShareClick()" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Tweet from '@/components/Tweet'
import { mapState, mapActions } from 'vuex'

export default {
  name: 'Tweet',
  components: {
    Tweet
  },
  props: {
    tweetData: {
      type: Object,
      required: true
    },
    nestLevel: {
      type: Number,
      required: true
    },
    injectClass: {
      type: Array,
      required: false,
      default: null
    },
    callback: {
      type: Function,
      required: false,
      default: null
    }
  },
  data () {
    return {
      tweet: null
    }
  },
  computed: {
    ...mapState({
      tweetModalResponse: state => state.tweetModal.response
    })
  },
  mounted () {
    // ただのリツイートはそれを表示
    this.tweet = (this.tweetData.tweet_type === 'retweet' && !this.tweetData.tweet_text) ? this.tweetData.ref_tweet : this.tweetData
  },
  methods: {
    ...mapActions({
      createTweet: 'tweetModal/createTweet'
    }),
    replyClick (refTweet) {
      this.$store.commit('tweetModal/SET_TWEET_TYPE', 'reply')
      this.$store.commit('tweetModal/SET_TWEET_TEXT', '')
      this.$store.commit('tweetModal/SET_REF_TWEET', refTweet)
      this.$bvModal.show('tweet_modal')
    },
    async reTweetClick (refTweet) {
      this.$store.commit('tweetModal/SET_TWEET_TYPE', 'retweet')
      this.$store.commit('tweetModal/SET_TWEET_TEXT', '')
      this.$store.commit('tweetModal/SET_REF_TWEET', refTweet)
      await this.createTweet()
      this.alertErrorMessage(this.tweetModalResponse)
      if (this.tweetModalResponse.status === 200) {
        if (this.callback) {
          this.callback()
        }
        this.$store.commit('tweetModal/SET_TWEET_TEXT', '')
        this.$store.commit('tweetModal/SET_REF_TWEET', {})
      }
    },
    refReTweetClick (refTweet) {
      this.$store.commit('tweetModal/SET_TWEET_TYPE', 'retweet')
      this.$store.commit('tweetModal/SET_TWEET_TEXT', '')
      this.$store.commit('tweetModal/SET_REF_TWEET', refTweet)
      this.$bvModal.show('tweet_modal')
    },
    async tweetUpdate (tweetId, favoriteCount) {
      const params = {
        favorite_count: favoriteCount
      }
      const response = await this.$axios.patch('/api/v1/tweets/' + tweetId, params).catch(err => err.response)
      this.alertErrorMessage(response)
    },
    async tweetDelete (tweetId) {
      const response = await this.$axios.delete('/api/v1/tweets/' + tweetId).catch(err => err.response)
      this.alertErrorMessage(response)
      if (response.status === 200) {
        if (this.callback) {
          this.callback()
        }
      }
    },
    tweetShareClick () {
      alert('未実装です')
    },
    alertErrorMessage (response) {
      if (response.status === 401) {
        alert('ログインしてください')
      } else if (response.status === 403) {
        alert('権限がありません')
      } else if (response.status === 422) {
        const errors = Object.keys(response.data.errors).map(key => response.data.errors[key][0])
        alert(errors.join('\n'))
      } else if (response.status === 500) {
        alert('サーバーエラーが発生しました')
      }
    }
  }
}
</script>

<style scoped>

.tweetIconButton, #retweet_dropdown /deep/ button, #tweet_other_dropdown /deep/ button {
    border: none;
    width: 24px;
    height: 24px;
    padding: 0;
    border-radius: 50%;
}
.tweetIconButton:focus,#retweet_dropdown /deep/ button:focus, #tweet_other_dropdown /deep/ button:focus {
    box-shadow: none;
}
.tweetIconButton:hover, #retweet_dropdown /deep/ button:hover, #tweet_other_dropdown /deep/ button:hover {
    color: orangered;
    background: rgb(255, 69, 0, 0.1);
}

.profileIcon {
  width: 42px;
  height: 42px;
  object-fit: cover;
}

</style>
