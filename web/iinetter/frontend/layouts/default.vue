<template>
  <div id="dafault">
    <div class="container">
      <div class="row">
        <header class="col-1" style="">
          <div class="d-flex flex-column align-items-center">
            <div class="position-fixed text-center" style="z-index: 2;">
              <div class="my-3">
                <nuxt-link :to="'/'">
                  <font-awesome-icon :icon="['fab', 'twitter']" class="fa-lg" style="color: orangered;" />
                </nuxt-link>
              </div>
              <div class="my-3">
                <nuxt-link :to="'/'">
                  <font-awesome-icon :icon="['fas', 'home']" class="fa-lg text-dark" />
                </nuxt-link>
              </div>
              <div class="my-3">
                <nuxt-link :to="'/'">
                  <font-awesome-icon :icon="['fas', 'hashtag']" class="fa-lg text-dark" />
                </nuxt-link>
              </div>
              <div class="my-3">
                <nuxt-link :to="'/'">
                  <font-awesome-icon :icon="['fas', 'bell']" class="fa-lg text-dark" />
                </nuxt-link>
              </div>
              <div class="my-3">
                <nuxt-link :to="'/'">
                  <font-awesome-icon :icon="['far', 'envelope']" class="fa-lg text-dark" />
                </nuxt-link>
              </div>
              <div class="my-3">
                <nuxt-link :to="'/'">
                  <font-awesome-icon :icon="['far', 'bookmark']" class="fa-lg text-dark" />
                </nuxt-link>
              </div>
              <div class="my-3">
                <nuxt-link :to="'/'">
                  <font-awesome-icon :icon="['far', 'list-alt']" class="fa-lg text-dark" />
                </nuxt-link>
              </div>
              <div class="my-3">
                <nuxt-link :to="'/setup_profile'">
                  <font-awesome-icon :icon="['far', 'user']" class="fa-lg text-dark" />
                </nuxt-link>
              </div>
              <div class="my-3">
                <b-dropdown id="dropdown" dropup no-caret variant="outline">
                  <template #button-content>
                    <font-awesome-icon :icon="['fas', 'ellipsis-h']" class="fa-lg text-dark" />
                  </template>
                  <b-dropdown-item @click="logout()">
                    ログアウト
                  </b-dropdown-item>
                </b-dropdown>
              </div>
            </div>
          </div>
        </header>
        <main class="col-11 p-0 border-left border-right" style="max-width: 600px;position: initial;z-index: 1;">
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
    }
  }
}
</script>

<style scoped>

#dropdown /deep/ button {
    border: none;
}
#dropdown /deep/ button:focus {
    box-shadow: none;
}
</style>
