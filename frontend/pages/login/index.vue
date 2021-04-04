<template>
  <!-- component -->
  <section class="min-h-screen flex flex-col">
      <nav>
          <div class="px-4 py-6">
            <insta-contacts-logo class="w-auto lg:mx-0 mx-auto h-10"></insta-contacts-logo>
          </div>
      </nav>
      <div class="flex flex-1 items-center justify-center">
          <div class="rounded-lg sm:border-2 px-4 lg:px-24 py-16 lg:max-w-xl sm:max-w-md w-full text-center">
              <form class="text-center" @submit.prevent="login">
                  <h1 class="font-bold tracking-wider text-3xl mb-8 w-full text-gray-600">
                    Вход
                  </h1>
                  <div class="py-2 text-left">
                      <input
                        type="email"
                        class="border-2 border-gray-100 focus:outline-none bg-gray-100 block w-full py-2 px-4 rounded-lg focus:border-gray-700 "
                        placeholder="Email"
                        autocomplete="username"
                        :class="{ 'border-red-500': !validations.email.valid }"
                        v-model="form.email"
                      />

                      <p class="text-red-500 text-xs italic" v-show="!validations.email.valid">
                        {{ validations.email.message }}
                      </p>
                  </div>
                  <div class="py-2 text-left">
                      <input
                        type="password"
                        autocomplete="current-password"
                        class="border-2 border-gray-100 focus:outline-none bg-gray-100 block w-full py-2 px-4 rounded-lg focus:border-gray-700 "
                        :class="{ 'border-red-500': !validations.password.valid }"
                        placeholder="Пароль"
                        v-model="form.password"
                      />

                      <p class="text-red-500 text-xs italic" v-show="!validations.password.valid">
                        {{ validations.password.message }}
                      </p>
                  </div>

                  <span class="text-xs text-red-500" v-show="!validations.invalidLogin.valid">
                    {{ validations.invalidLogin.message }}
                  </span>

                  <div class="py-2">
                      <button
                        type="submit"
                        class="border-2 border-gray-100 focus:outline-none bg-purple-600 text-white font-bold tracking-wider block w-full p-2 rounded-lg focus:border-gray-700 hover:bg-purple-700"
                      >
                          Войти
                      </button>
                  </div>
              </form>
              <div class="text-center mt-12">
                  <span>
                    Впервые на i-Contacts?
                  </span>
                  <nuxt-link to="/register" class="font-light text-md text-indigo-600 underline font-semibold hover:text-indigo-800">Регистрация</nuxt-link>
              </div>
          </div>
      </div>
  </section>
</template>

<script>
import InstaContactsLogo from '@/assets/img/logos/header-logo.svg?inline';

export default {
  middleware: ['guest'],
  components: {
    InstaContactsLogo
  },
  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      validations: {
        email: {
          valid: true,
          message: ''
        },
        password: {
          valid: true,
          message: ''
        },
        invalidLogin: {
          valid: true,
          message: ''
        }
      }
    };
  },
  methods: {
    validateLogin() {
      if ( this.form.email == '' || this.form.email.match(/^(([^<>()[\]\\.,;:\s@\"] +(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\. [0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+ [a-zA-Z]{2,}))$/) ) {
        this.validations.email.valid = false;
        this.validations.email.message = 'Для входа необходимо ввести действующий email';
      } else {
        this.validations.email.valid = true;
        this.validations.email.message = '';
      }

      if ( this.form.password == '' ) {
        this.validations.password.valid = false;
        this.validations.password.message = 'Необходимо ввести пароль';
      } else {
        this.validations.password.valid = true;
        this.validations.password.message = '';
      }

      return ( this.validations.email.valid && this.validations.password.valid ) ? true : false;
    },

    login() {
      if (this.validateLogin()) {
        this.$auth.loginWith('laravelSanctum', { data: this.form })
          .then( function () {
              // Handle successful login
              this.$router.push('/')
            }.bind(this)
          )
          .catch( function (error) {
              // Handle login errors
              this.validations.invalidLogin.valid = false;
              this.validations.invalidLogin.message = 'Неверные данные, попробуйте еще раз!!'
              this.validations.email.valid = false;
              this.validations.password.valid = false;
            }.bind(this)
          );
      }
    }
  }
}
</script>