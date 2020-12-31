<template>
  <form class="form-group">
    <div v-if="tweetType === 'reply' && refTweet" class="row">
      <div class="col-12 pb-3">
        <div class="border-bottom">
          <Tweet :tweet-data="refTweet" :callback="refresh" />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-2 text-center">
        <img v-if="this.$auth.user.user_profile" :src="this.$auth.user.user_profile.icon_url" class="rounded-circle profileIcon">
        <img v-else src="http://localhost/images/user_icon_default.png" class="rounded-circle profileIcon">
      </div>
      <div class="col-10 pl-0">
        <div class="row">
          <div class="col-12 my-2">
            <textarea
              v-model="tweetText"
              :rows="tweetTextRows"
              placeholder="コメントを追加"
              class="form-control border-0 tweetTextbox"
              style="resize: none"
            />
          </div>
        </div>
        <!-- 引用リツイート -->
        <div v-if="tweetType === 'retweet' && refTweet" class="my-2 p-2 border" style="border-radius: 16px;">
          <div class="row">
            <div class="col-2 text-center">
              <img v-if="refTweet.user.user_profile" :src="refTweet.user.user_profile.icon_url" class="rounded-circle profileIcon">
              <img v-else src="http://localhost/images/user_icon_default.png" class="rounded-circle profileIcon">
            </div>
            <div class="col-10 pl-0">
              <div>
                <nuxt-link :to="'/'+refTweet.user.name">
                  {{ refTweet.user.name }}
                </nuxt-link>
                <span v-if="refTweet.user.user_profile && refTweet.user.user_profile.screen_name">
                  @{{ refTweet.user.user_profile.screen_name }}
                </span>
              </div>
              <div class="mb-2" style="white-space: pre;" v-text="refTweet.tweet_text" />
            </div>
          </div>
        </div>
        <div class="d-flex">
          <div class="">
            <button type="button" class="btn rounded-circle tweetIconButton">
              <font-awesome-icon :icon="['fas', 'image']" class="" />
            </button>
          </div>
          <div class="mx-auto" />
          <div class="text-center">
            <button
              type="button"
              class="btn rounded-pill font-weight-bold tweetButton"
              :disabled="tweetText.length === 0"
              @click="create"
            >
              ツイートする
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import Tweet from '@/components/Tweet'
import { mapState, mapActions } from 'vuex'

export default {
  components: {
    Tweet
  },
  props: {
    callback: {
      type: Function,
      required: false,
      default: null
    }
  },
  data () {
    return {
      tweetText: ''
    }
  },
  computed: {
    ...mapState({
      tweetType: state => state.tweetModal.tweetType,
      refTweet: state => state.tweetModal.refTweet
    }),
    tweetTextRows () {
      return this.tweetText.split('\n').length
    }
  },
  methods: {
    ...mapActions({
      createTweet: 'tweetModal/createTweet'
    }),
    async create () {
      this.$store.commit('tweetModal/SET_TWEET_TEXT', this.tweetText)
      await this.createTweet()
      if (this.callback) {
        this.callback()
      }
      this.$bvModal.hide('tweet_modal')
    }
  }
}
</script>

<style scoped>
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
.profileIcon {
  width: 50px;
  height: 50px;
  object-fit: cover;
}
</style>
