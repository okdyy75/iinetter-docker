<template>
  <div class="login">
    <div class="row">
      <div class="col-6 mx-auto text-center my-5">
        <font-awesome-icon :icon="['fab', 'twitter']" class="fa-2x" style="color: orangered;" />
        <h1 class="h5 font-weight-bold pt-4">
          ログイン
        </h1>
        <form @submit.prevent="submit">
          <div class="form-group">
            <input v-model="email" type="email" class="form-control py-4" placeholder="メールアドレス">
          </div>
          <div class="form-group">
            <input v-model="password" type="password" class="form-control py-4" placeholder="パスワード">
          </div>
          <button
            type="submit"
            class="btn rounded-pill font-weight-bold w-100 p-2"
            style="color: white;background-color: #1DA1F2"
          >
            ログイン
          </button>

          <div class="mt-3">
            <nuxt-link :to="'/signup'">
              アカウント作成
            </nuxt-link>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  layout: 'simple',
  data () {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    async submit () {
      const response = await this.$auth.loginWith('local', {
        data: {
          email: this.email,
          password: this.password
        }
      }).catch(err => err.response)

      if (response.status !== 200) {
        const errors = Object.keys(response.data.errors).map(key => response.data.errors[key][0])
        alert(errors.join('\n'))
      }
    }
  }
}
</script>
