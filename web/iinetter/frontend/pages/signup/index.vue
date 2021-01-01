<template>
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mx-auto text-center my-5">
        <font-awesome-icon :icon="['fab', 'twitter']" class="fa-2x" style="color: orangered;" />
        <h1 class="h5 font-weight-bold pt-4">
          アカウントを作成
        </h1>
        <form @submit.prevent="submit">
          <div class="form-group">
            <input v-model="name" type="text" class="form-control py-4" placeholder="名前（半角英数字のみ）">
          </div>
          <div class="form-group">
            <input v-model="email" type="email" class="form-control py-4" placeholder="メールアドレス">
          </div>
          <div class="form-group">
            <input v-model="password" type="password" class="form-control py-4" placeholder="パスワード（半角英数字8文字以上）">
          </div>
          <div class="form-group">
            <input v-model="password_confirmation" type="password" class="form-control py-4" placeholder="パスワード確認">
          </div>
          <button
            type="submit"
            class="btn rounded-pill font-weight-bold w-100 p-2"
            style="color: white;background-color: orangered"
          >
            アカウント作成
          </button>

          <div class="mt-3">
            <nuxt-link :to="'/login'">
              ログイン
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
  auth: false,
  middleware ({ store, redirect }) {
    if (store.$auth.loggedIn) {
      redirect('/')
    }
  },
  data () {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    }
  },
  methods: {
    async submit () {
      const response = await this.$axios.post('api/v1/register', {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation
      }).catch(err => err.response)

      if (response.status === 201) {
        // そのままログイン
        await this.$auth.loginWith('local', {
          data: {
            email: this.email,
            password: this.password
          }
        })
        this.$router.push('/')
      } else {
        const errors = Object.keys(response.data.errors).map(key => response.data.errors[key][0])
        alert(errors.join('\n'))
      }
    }
  }
}
</script>
