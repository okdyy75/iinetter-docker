<template>
  <div id="dafault">
    <div class="container">
      <div class="row">
        <header class="col-1 p-0" style="z-index: 2;">
          <div class="d-flex flex-column align-items-center">
            <div class="position-fixed text-center">
              <div class="my-2">
                <nuxt-link :to="'/'">
                  <button type="button" class="btn rounded-circle tweetIconButton" style="color: orangered;">
                    <font-awesome-icon :icon="['fab', 'twitter']" class="fa-lg" />
                  </button>
                </nuxt-link>
              </div>
              <div class="my-2">
                <nuxt-link :to="'/'" active-class="active" exact>
                  <button type="button" class="btn rounded-circle tweetIconButton">
                    <font-awesome-icon :icon="['fas', 'home']" class="fa-lg" />
                  </button>
                </nuxt-link>
              </div>
              <div class="my-2">
                <button type="button" class="btn rounded-circle tweetIconButton" @click="searchButtonClick()">
                  <font-awesome-icon :icon="['fas', 'search']" class="fa-lg" />
                </button>
              </div>
              <div class="my-2">
                <button type="button" class="btn rounded-circle tweetIconButton" @click="bellButtonClick()">
                  <font-awesome-icon :icon="['fas', 'bell']" class="fa-lg" />
                </button>
              </div>
              <div class="my-2">
                <button type="button" class="btn rounded-circle tweetIconButton" @click="envelopeButtonClick()">
                  <font-awesome-icon :icon="['far', 'envelope']" class="fa-lg" />
                </button>
              </div>
              <div class="my-2">
                <nuxt-link :to="'/setup_profile'">
                  <button type="button" class="btn rounded-circle tweetIconButton">
                    <font-awesome-icon :icon="['far', 'user']" class="fa-lg" />
                  </button>
                </nuxt-link>
              </div>
              <div class="my-2">
                <b-dropdown id="left_menu_dropdown" dropup no-caret variant="outline">
                  <template #button-content>
                    <font-awesome-icon :icon="['fas', 'ellipsis-h']" class="fa-lg" />
                  </template>
                  <b-dropdown-item @click="logout()">
                    ログアウト
                  </b-dropdown-item>
                </b-dropdown>
              </div>
            </div>
          </div>
        </header>
        <main class="col-11 p-0 border-left border-right" style="z-index: 1;max-width: 600px;min-height: 100vh;">
          <Nuxt />
        </main>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    logout () {
      this.$auth.logout()
    },
    searchButtonClick () {
      alert('未実装です')
    },
    bellButtonClick () {
      alert('未実装です')
    },
    envelopeButtonClick () {
      alert('未実装です')
    }
  }
}
</script>

<style scoped>
.active {
  color: orangered !important ;
}
.tweetIconButton, #left_menu_dropdown /deep/ button {
    border: none;
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 50%;
}
.tweetIconButton:focus, #left_menu_dropdown /deep/ button:focus {
    box-shadow: none;
}
.tweetIconButton:hover, #left_menu_dropdown /deep/ button:hover {
    color: orangered;
    background: rgb(255, 69, 0, 0.1);
}
</style>
