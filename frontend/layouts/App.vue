<template>
  <div id="app-layout" class="flex flex-col min-h-screen bottom_space w-screen select-none safe-top safe-left safe-right safe-bottom">
    <app-header />

    <main>
      <nuxt />
    </main>

    <app-footer/>
  </div>
</template>

<script>
import AppHeader from "@/components/global/Header/AppHeader"
import AppFooter from "@/components/global/Footer/AppFooter"

export default {
  components: {
    AppHeader,
    AppFooter
  }
}
</script>

<style>
  body {
    overflow-x: hidden;
  }

  .bookmark {
    position: absolute;
    bottom: 10px;
    right: 10px;
  }
</style>