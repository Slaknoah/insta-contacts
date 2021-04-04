<template>
  <div class="relative bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 md:block hidden">
      <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
        <div class="lg:w-0 lg:flex-1 hidden md:block">
          <nuxt-link to="/" class="flex items-center">
            <insta-contacts-logo class="h-10 w-auto"></insta-contacts-logo>
          </nuxt-link>
        </div>

        <!-- Profile dropdown -->
        <div
          v-if="$auth.loggedIn"
          class="hidden ml-3 relative md:flex justify-end md:flex-1"
          @mouseover="isUserMenuActive = true"
          @mouseleave="isUserMenuActive = false"
        >
          <div>
            <button class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid"
                    id="user-menu"
                    aria-label="User menu"
                    aria-haspopup="true">
              <img class="h-8 w-8 rounded-full" src="https://www.dovercourt.org/wp-content/uploads/2019/11/610-6104451_image-placeholder-png-user-profile-placeholder-image-png.jpg" alt="">
            </button>
          </div>

          <transition enter-active-class="transition ease-out duration-100"
                      enter-class="transform opacity-0 scale-95"
                      enter-to-class="transform opacity-100 scale-100"
                      leave-active-class="transition ease-in duration-75"
                      leave-class="transform opacity-100 scale-100"
                      leave-to-class="transform opacity-0 scale-95">
            <div class="z-30 origin-top-right absolute right-0 mt-10 w-48 rounded-md shadow-lg" v-show="isUserMenuActive">
              <div class="py-1 rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                <nuxt-link to="/account/contacts" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Мои контакты</nuxt-link>

                <a @click.prevent="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Выйти</a>
              </div>
            </div>
          </transition>
        </div>
      </div>
    </div>

    <div class="px-4 md:hidden">
      <div class="flex justify-between items-center border-b-2 border-gray-100 py-4 md:justify-start md:space-x-10">
        <div class="logo block">
          <nuxt-link to="/" class="flex items-center">
            <insta-contacts-logo-sm class="h-7 w-auto"></insta-contacts-logo-sm>
          </nuxt-link>
        </div>

        <!-- Profile dropdown -->
        <div
          v-if="$auth.loggedIn"
          class="ml-3 relative md:flex justify-end md:flex-1"
          @mouseover="isUserMenuActive = true"
          @mouseleave="isUserMenuActive = false"
        >
          <div>
            <button class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none focus:shadow-solid"
                    id="user-menu"
                    aria-label="User menu"
                    aria-haspopup="true">
              <img class="h-8 w-8 rounded-full" src="https://www.dovercourt.org/wp-content/uploads/2019/11/610-6104451_image-placeholder-png-user-profile-placeholder-image-png.jpg" alt="">
            </button>
          </div>

          <transition
            enter-active-class="transition ease-out duration-100"
            enter-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
          >
            <div class="z-30 origin-top-right absolute right-0 w-48 rounded-md shadow-lg" v-show="isUserMenuActive">
              <div class="py-1 rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                <nuxt-link to="/account/contacts" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Мои контакты</nuxt-link>

                <a @click.prevent="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Выйти</a>
              </div>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import InstaContactsLogo from '@/assets/img/logos/header-logo.svg?inline';
import InstaContactsLogoSm from '@/assets/img/logos/header-logo-sm.svg?inline';

export default {
  data() {
    return {
      isUserMenuActive: false
    }
  },
  components: {
    InstaContactsLogo,
    InstaContactsLogoSm
  },
  methods: {
    async logout () {
      await this.$auth.logout();
      this.$router.push('/login');
    },
  },
  watch: {
    $route() {
      this.isUserMenuActive = false;
    }
  }
}
</script>