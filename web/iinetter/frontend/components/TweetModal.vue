<template>
  <div v-if="!this.$auth.loggedIn">
    ログインしてください
  </div>
  <form v-else class="form-group">
    <div v-if="tweetType === 'reply' && refTweet" class="row">
      <div class="col-12 pb-3">
        <div class="border-bottom">
          <Tweet :tweet-data="refTweet" :nest-level="2" />
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
        <template v-if="tweetType === 'retweet'">
          <div v-if="refTweet" class="my-2 p-2 border" style="border-radius: 16px;">
            <Tweet :tweet-data="refTweet" :nest-level="2" />
          </div>
        </template>

        <div class="d-flex">
          <div class="">
            <button type="button" class="btn rounded-circle tweetIconButton" @click="selectImageClick()">
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
      refTweet: state => state.tweetModal.refTweet,
      tweetModalResponse: state => state.tweetModal.response
    }),
    tweetTextRows () {
      return this.tweetText.split('\n').length
    }
  },
  methods: {
    ...mapActions({
      createTweet: 'tweetModal/createTweet'
    }),
    selectImageClick () {
      alert('未実装です')
    },
    async create () {
      this.$store.commit('tweetModal/SET_TWEET_TEXT', this.tweetText)
      await this.createTweet()
      this.alertErrorMessage(this.tweetModalResponse)
      if (this.tweetModalResponse.status === 200) {
        if (this.callback) {
          this.callback()
        }
        this.$store.commit('tweetModal/SET_TWEET_TEXT', '')
        this.$store.commit('tweetModal/SET_REF_TWEET', {})
        this.$bvModal.hide('tweet_modal')
      }
    },
    alertErrorMessage (response) {
      if (response.status === 401) {
        alert('ログインしてください')
      } else if (response.status === 403) {
        alert('権限がありません')
      } else if (response.status === 422) {
        const errors = Object.keys(response.data.errors).map(key => response.data.errors[key][0])
        alert(errors.join('\n'))
      }
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
  background: orangered
}
.tweetIconButton {
  border: none;
  width: 24px;
  height: 24px;
  padding: 0;
  border-radius: 50%;
}
.tweetIconButton:focus {
  box-shadow: none;
}
.tweetIconButton:hover {
  color: orangered;
  background: rgb(255, 69, 0, 0.1);
}
.profileIcon {
  width: 42px;
  height: 42px;
  object-fit: cover;
}
</style>
