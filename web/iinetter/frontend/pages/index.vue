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
              <div class="col-2 text-center">
                <img v-if="this.$auth.user.user_profile" :src="this.$auth.user.user_profile.icon_url" class="rounded-circle profileIcon">
                <img v-else src="http://localhost/images/user_icon_default.png" class="rounded-circle profileIcon">
              </div>
              <div class="col-10 pl-0">
                <div class="row">
                  <div class="col-12 my-2">
                    <textarea
                      v-model="form.tweetText"
                      :rows="tweetTextRows"
                      placeholder="いまどうしてる？"
                      class="form-control border-0 tweetTextbox"
                      style="resize: none"
                    />
                  </div>
                </div>
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
                      :disabled="form.tweetText.length === 0"
                      @click="create"
                    >
                      ツイートする
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="timeline">
        <div v-for="tweet in tweets" :key="tweet.id" class="border-bottom">
          <Tweet :tweet-data="tweet" :nest-level="1" :callback="refresh" />
        </div>
      </div>
    </div>
    <!-- モーダル -->
    <b-modal id="tweet_modal" :hide-footer="true">
      <TweetModal :callback="refresh" />
    </b-modal>
  </div>
</template>

<script>
import TweetModal from '@/components/TweetModal'
import Tweet from '@/components/Tweet'

export default {
  components: {
    TweetModal,
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
        tweetType: 'tweet',
        tweetText: ''
      },
      tweets: []
    }
  },
  computed: {
    tweetTextRows () {
      return this.form.tweetText.split('\n').length
    }
  },
  methods: {
    selectImageClick () {
      alert('未実装です')
    },
    async create () {
      const params = {
        tweet_type: this.form.tweetType,
        tweet_text: this.form.tweetText
      }
      const response = await this.$axios.post('/api/v1/tweets', params).catch(err => err.response)
      if (response.status !== 200) {
        const errors = Object.keys(response.data.errors).map(key => response.data.errors[key][0])
        alert(errors.join('\n'))
      } else {
        this.form.tweetText = ''
        this.$fetch()
      }
    },
    refresh () {
      this.$fetch()
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
  background: orangered
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
    color: orangered;
    background: rgb(255, 69, 0, 0.1);
}
.profileIcon {
  width: 42px;
  height: 42px;
  object-fit: cover;
}
</style>
