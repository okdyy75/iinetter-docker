<template>
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mx-auto text-center my-5">
        <font-awesome-icon :icon="['fab', 'twitter']" class="fa-2x" style="color: orangered;" />
        <h1 class="h5 font-weight-bold pt-4">
          プロフィールを作成
        </h1>
        <form @submit.prevent="submit">
          <div class="form-group">
            <input v-model="form.screen_name" type="text" class="form-control py-4" placeholder="表示名">
          </div>
          <div class="form-group">
            <input v-model="form.description" type="textarea" class="form-control py-4" placeholder="自己紹介">
          </div>
          <div class="form-group">
            <input v-model="form.location" type="text" class="form-control py-4" placeholder="場所">
          </div>
          <div class="form-group">
            <input v-model="form.url" type="text" class="form-control py-4" placeholder="URL">
          </div>
          <div class="form-group">
            <b-form-file v-model="form.icon" placeholder="未選択" browse-text="アイコン" />
          </div>
          <div class="form-group">
            <b-form-file v-model="form.header_image" placeholder="未選択" browse-text="ヘッダー画像" />
          </div>
          <button
            type="submit"
            class="btn rounded-pill font-weight-bold w-100 p-2"
            style="color: white;background-color: orangered"
          >
            プロフィール更新
          </button>
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
      form: {
        screen_name: '',
        description: '',
        location: '',
        url: '',
        icon: [],
        header_image: []
      }
    }
  },
  methods: {
    async submit () {
      const fd = new FormData()
      Object.entries(this.form).forEach(([key, value]) => {
        if (value.length > 0 || value.size) {
          fd.append(key, value)
        }
      })

      const response = await this.$axios.post('api/v1/user_profile', fd, {
        headers: {
          'content-type': 'multipart/form-data'
        }
      }).catch(err => err.response)
      this.alertErrorMessage(response)
      if (response.status === 200) {
        // プロフィール画像が更新されないので直接リロードさせる
        location.href = '/'
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
      } else if (response.status === 500) {
        alert('サーバーエラーが発生しました')
      }
    }
  }
}
</script>
