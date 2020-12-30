<template>
  <div class="container">
    <div class="row">
      <div class="col-6 mx-auto text-center my-5">
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
            <b-form-file v-model="form.icon" placeholder="ファイル未選択" browse-text="アイコン" />
          </div>
          <div class="form-group">
            <b-form-file v-model="form.header_image" placeholder="ファイル未選択" browse-text="ヘッダー画像" />
          </div>
          <button
            type="submit"
            class="btn rounded-pill w-100 p-2"
            style="color: white;background-color: #1DA1F2"
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

      if (response.status === 200) {
        // そのままトップに
        this.$router.push('/')
      } else {
        const errors = Object.keys(response.data.errors).map(key => response.data.errors[key][0])
        alert(errors.join('\n'))
      }
    }
  }
}
</script>
