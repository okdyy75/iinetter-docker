<template>
  <div v-if="!$fetchState.pending" class="user_name">
    <div class="position-sticky">
      <div class="sticky-top border-bottom bg-white">
        <div class="row m-2">
          <div class="d-flex">
            <button type="button" class="btn rounded-circle align-self-center tweetIconButton" @click="$router.go(-1)">
              <font-awesome-icon :icon="['fa', 'arrow-left']" class="" />
            </button>
          </div>
          <div class="col-10">
            <h1 class="h5 m-0 font-weight-bold">
              {{ userName }}
            </h1>
            <span class="small font-weight-bold text-secondary">{{ tweet_count }}件のツイート</span>
          </div>
        </div>
      </div>
      <div class="border-bottom">
        <div v-if="userHeaderImageUrl" :style="{height: '200px', background: 'center / cover no-repeat url(' + userHeaderImageUrl + ')'}" />
        <div v-else :style="{height: '200px', background: 'center / cover no-repeat #C4CFD5'}" />
      </div>
      <div>
        <div class="m-2" style="height: 50px;">
          <img v-if="userIconUrl" :src="userIconUrl" class="rounded-circle mainProfileIcon">
          <img v-else src="http://localhost/images/user_icon_default.png" class="rounded-circle mainProfileIcon">
          <nuxt-link :to="'/setup_profile'">
            <button
              v-if="$auth.user.name === $route.params.user_name"
              type="button"
              class="btn rounded-pill font-weight-bold mr-2 profileSettingButton"
            >
              プロフィールを設定
            </button>
          </nuxt-link>
        </div>
      </div>
      <div class="border-bottom">
        <div class="m-2 ml-3">
          <div class="mb-1 h5 font-weight-bold">
            {{ userName }}
          </div>
          <div v-if="userScreenName" class="small font-weight-bold text-secondary">
            @{{ userScreenName }}
          </div>
        </div>
      </div>
      <div class="timeline">
        <template v-if="tweets.length">
          <div v-for="tweet in tweets" :key="tweet.id" class="border-bottom">
            <Tweet :tweet-data="tweet" :nest-level="1" :callback="toTop" />
          </div>
        </template>
        <template v-else>
          <div class="border-bottom">
            <div class="p-2">
              ツイートがありません
            </div>
          </div>
        </template>
      </div>
    </div>
    <!-- モーダル -->
    <b-modal id="tweet_modal" :hide-footer="true">
      <TweetModal :callback="toTop" />
    </b-modal>
  </div>
</template>

<script>
import TweetModal from '@/components/TweetModal'
import Tweet from '@/components/Tweet'

export default {
  auth: false,
  components: {
    TweetModal,
    Tweet
  },
  async fetch () {
    const response = await this.$axios.get('/api/v1/users/' + this.$route.params.user_name, {
      params: { ...this.$route.query }
    })
    const user = response.data.data
    this.userName = user.name
    this.tweets = user.tweets
    this.tweet_count = user.tweets.length
    if (user.user_profile) {
      this.userScreenName = user.user_profile.screen_name
      this.userHeaderImageUrl = user.user_profile.header_image_url
      this.userIconUrl = user.user_profile.icon_url
    }
  },
  data () {
    return {
      userName: '',
      userScreenName: '',
      userHeaderImageUrl: '',
      userIconUrl: '',
      tweet_count: 0,
      tweets: []
    }
  },
  methods: {
    toTop () {
      this.$router.push('/')
    }
  }
}
</script>

<style scoped>

.mainProfileIcon {
  position: relative;
  top: -88px;
  object-fit: cover;
  width: 142px;
  height: 142px;
  background-color: #FFFFFF;
  border: solid 4px #FFFFFF;
}
.profileSettingButton {
  position: absolute;
  right: 0;
  color: #1DA1F2;
  border: 1px solid #1DA1F2
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
  color: #1DA1F2;
  background-color: rgba(29, 161, 242, 0.1);
}

</style>
