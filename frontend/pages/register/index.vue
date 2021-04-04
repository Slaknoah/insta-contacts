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
            <form class="text-center" @submit.prevent="register">
              <h1 class="font-bold tracking-wider text-3xl mb-8 w-full text-gray-600">
                Регистрация
              </h1>
              <div class="py-2 text-left">
                  <input
                    type="text"
                    class="border-2 border-gray-100 focus:outline-none bg-gray-100 block w-full py-2 px-4 rounded-lg focus:border-gray-700 "
                    placeholder="Имя"
                    v-model="form.name"
                    :class="{ 'border-red-500': !validations.name.valid }"
                  />

                  <p class="text-red-500 text-xs italic" v-show="!validations.name.valid">
                    {{validations.name.message}}
                  </p>
              </div>

              <div class="py-2 text-left">
                  <input
                    type="email"
                    class="border-2 border-gray-100 focus:outline-none bg-gray-100 block w-full py-2 px-4 rounded-lg focus:border-gray-700 "
                    :class="{ 'border-red-500': !validations.email.valid }"
                    v-model="form.email"
                    placeholder="Email" />

                  <p class="text-red-500 text-xs italic" v-show="!validations.email.valid">
                    {{validations.email.message}}
                  </p>
              </div>

              <div class="py-2 text-left">
                  <input
                    type="password"
                    v-model="form.password"
                    :class="{ 'border-red-500': !validations.password.valid }"
                    autocomplete="new-password"
                    class="border-2 border-gray-100 focus:outline-none bg-gray-100 block w-full py-2 px-4 rounded-lg focus:border-gray-700 "
                    placeholder="Пароль"
                  />

                  <p class="text-red-500 text-xs italic" v-show="!validations.password.valid">
                    {{validations.password.message}}
                  </p>

                  <div class="flex items-center mt-2">
                    <span class="rounded-full mr-1 w-12 h-1 block"
                          v-bind:class="{
                                'bg-red-500' : passwordStrength.score <= 1,
                                'bg-yellow-700' : passwordStrength.score == 2,
                                'bg-yellow-500' : passwordStrength.score == 3,
                                'bg-green-500' : passwordStrength.score == 4
                            }"></span>
                    <span class="rounded-full mr-1 w-12 h-1 block"
                            v-bind:class="{
                                'bg-gray-500' : passwordStrength.score <= 1,
                                'bg-yellow-700' : passwordStrength.score == 2,
                                'bg-yellow-500' : passwordStrength.score == 3,
                                'bg-green-500' : passwordStrength.score == 4
                            }"></span>
                    <span class="rounded-full mr-1 w-12 h-1 block"
                            v-bind:class="{
                                'bg-gray-500' : passwordStrength.score <= 2,
                                'bg-yellow-500' : passwordStrength.score == 3,
                                'bg-green-500' : passwordStrength.score == 4
                            }"></span>
                    <span class="rounded-full mr-1 w-12 h-1 block"
                            v-bind:class="{
                                'bg-gray-500' : passwordStrength.score <= 3,
                                'bg-green-500' : passwordStrength.score == 4
                            }"></span>
                  </div>
              </div>

              <div class="py-2 text-left">
                  <input
                    type="password"
                    class="border-2 border-gray-100 focus:outline-none bg-gray-100 block w-full py-2 px-4 rounded-lg focus:border-gray-700 "
                    placeholder="Повторите пароль"
                    :class="{ 'border-red-500': !validations.confirm_password.valid }"
                    v-model="form.confirm_password"
                  />

                  <p class="text-red-500 text-xs italic" v-show="!validations.confirm_password.valid">
                    {{validations.confirm_password.message}}
                  </p>
              </div>

              <span class="text-xs text-red-500" v-show="!validations.invalidRegister.valid">
                {{ validations.invalidRegister.message }}
              </span>

              <div class="py-2">
                  <button
                    type="submit"
                    class="border-2 border-gray-100 focus:outline-none bg-purple-600 text-white font-bold tracking-wider block w-full p-2 rounded-lg focus:border-gray-700 hover:bg-purple-700"
                  >
                      Регистрация
                  </button>
              </div>
            </form>
            <div class="text-center mt-12">
                <span>
                  Уже есть аккаунт ?
                </span>
                <nuxt-link to="/login" class="font-light text-md text-indigo-600 underline font-semibold hover:text-indigo-800">Войти</nuxt-link>
            </div>
        </div>
      </div>
  </section>
</template>

<script>
import InstaContactsLogo from '@/assets/img/logos/header-logo.svg?inline';
const zxcvbn = require('zxcvbn');

export default {
  middleware: ['guest'],
  components: {
    InstaContactsLogo
  },
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        confirm_password: ''
      },
      validations: {
        name: {
          valid: true,
          message: ''
        },
        email: {
          valid: true,
          message: ''
        },
        password: {
          valid: true,
          message: ''
        },
        confirm_password: {
          valid: true,
          message: ''
        },
        invalidRegister: {
          valid: true,
          message: ''
        }
      }
    }
  },
  methods: {
    register() {
      if ( this.validateRegistration() ) {
        this.$axios.get('/sanctum/csrf-cookie')
          .then( function() {
            this.$axios.post('/register', this.form)
              .then( function( response ) {
                  this.$auth.loginWith( 'laravelSanctum', { data: this.form } )
                    .then( function() {
                      // Handle authentication success
                      this.$router.push('/');
                    }.bind(this) )
                }.bind(this)
              )
              .catch( function( error ) {
                  // Handle registration failure and show error messages
                  this.validations.invalidRegister.valid = false;
                  this.validations.invalidRegister.message = 'Неверные данные, попробуйте еще раз'
                }.bind(this)
              )
          }.bind(this));
      }
    },
    validateRegistration() {
      let formValid = true;

      if (this.form.name == '') {
        this.validations.name.valid = false;
        this.validations.name.message = 'В этом поле необходимо указать имя';
        formValid = false;
      } else {
        this.validations.name.valid = true;
        this.validations.name.message = '';
      }

      if (this.form.email == '' || !this.form.email.match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
        this.validations.email.valid = false;
        this.validations.email.message = 'Необходимо ввести действующий адрес электронной почты.';
        formValid = false;
      } else {
        this.validations.email.valid = true;
        this.validations.email.message = '';
      }

      if (this.form.password == '' || this.passwordStrength.score < 4) {
        this.validations.password.valid = false;
        this.validations.password.message = 'Необходимо ввести надежный пароль';
        formValid = false;
      } else {
        this.validations.password.valid = true;
        this.validations.password.message = '';
      }

      if (this.form.confirm_password == '' || this.form.confirm_password != this.form.password) {
        this.validations.confirm_password.valid = false;
        this.validations.confirm_password.message = 'Ваши пароли должны совпадать';
        formValid = false;
      } else {
        this.validations.confirm_password.valid = true;
        this.validations.confirm_password.message = '';
      }


      return formValid;
    }
  },
  computed: {
    passwordStrength(){
      return zxcvbn( this.form.password );
    }
  },
}
</script>