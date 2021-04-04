<template>
  <div>
    <div class="flex flex-col pb-10 md:pt-10 pt-4 w-full mx-auto max-w-screen-xl">
      <div class="px-4 sm:px-6 mb-5 flex items-center justify-between">
        <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:leading-9 sm:truncate">
          Контакты
        </h1>
      </div>

      <div class="px-4 sm:px-6 flex items-center">
        <div class="w-full relative text-gray-600 focus-within:text-gray-400">
          <span class="absolute inset-y-0 left-0 flex items-center pl-2">
            <button type="submit" class="p-1 focus:outline-none focus:shadow-outline">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-6 h-6"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
          </span>
          <input
            type="search"
            v-model="search"
            class="w-full py-4 text-sm text-white bg-purple-white shadow rounded-md pl-10 focus:outline-none focus:bg-white focus:text-gray-900"
            placeholder="Поиск по имени, email или номеру телефона..."
            autocomplete="off"
          >
        </div>
      </div>

      <div v-if="contacts.length" class="companies-list mt-4 flex justify-around flex-wrap overflow-x-auto pt-2 px-4 sm:px-6 lg:flex-wrap">
        <div
          v-for="contact in contacts"
          :key="contact.id"
          class="relative flex-grow-0 flex-shrink-0 mb-5 w-full sm:w-48 md:w-56.25">

          <div class="bg-white border-b-2 border-gray-200 rounded-15" style="box-shadow: rgba(0, 0, 0, 0.21) 0px 2px 9px 0px;">
            <div class="block w-full bg-center bg-cover rounded-t-15 h-40 md:h-48" :style="'background-image: url(' + contact.avatar + ');'">
            </div>
            <div class="flex flex-col border-t border-lightBlueBorder py-5 px-4">
              <span class="font-bold text-base w-full truncate">{{ contact.full_name }}</span>

              <a :href="`tel:${contact.phone_number}`" class="text-xs text-textGray">{{ contact.phone_number }}</a>
              <a :href="`mailto:${contact.email}`" class="text-xs text-textGray">{{ contact.email }}</a>
            </div>
          </div>

          <div class="bookmark flex flex-col items-center">
            <book-marked class="cursor-pointer" @click="bookmarkContact( contact.id )" v-if="contact.bookmarked"></book-marked>
            <book-mark class="cursor-pointer" @click="bookmarkContact( contact.id )" v-else></book-mark>
          </div>
        </div>
      </div>

      <div class="px-4 sm:px-6 w-full">
        <button
          v-show="showLoadMore"
          @click="loadMoreContacts"
          class="border-2 tracking-wider mx-auto border-gray-100 focus:outline-none bg-purple-600 text-white font-bold block p-2 px-4 mt-2 rounded-lg focus:border-gray-700 hover:bg-purple-700"
        >
          Загрузить еще
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import BookMark from '@/assets/img/ui/bookmark.svg?inline';
import BookMarked from '@/assets/img/ui/bookmarked.svg?inline';

export default {
  layout: 'App',
  middleware: ['auth'],
  async asyncData( ctx ) {
    const { data, meta } = await ctx.app.$api.contacts.index({ take: 10 });
    return {
      contacts: data,
      contactsMeta: meta
    }
  },
  components: {
    BookMark,
    BookMarked
  },
  data() {
    return {
      search: '',
      itemsPerPage: 10,
    }
  },
  computed: {
    showLoadMore() {
      if( this.contactsMeta && this.contactsMeta.current_page ) {
        return ( this.contactsMeta.current_page <  this.contactsMeta.last_page )
      }

      return false;
    }
  },
  methods: {
    async bookmarkContact( contactId ) {
      let toggleLike = await this.$api.contacts.bookmark( contactId );

      this.contacts.forEach( function( contact, index ) {
        if( contact.id == contactId )
          this.$set( this.contacts[ index ], 'bookmarked', toggleLike.status );
      }.bind( this ) )
    },
    buildSearchParams( page ) {
      let searchParams = {};

      searchParams.page = page;
      searchParams.take = this.itemsPerPage;

      if( this.search ) {
        searchParams.search = this.search;
      }

      return searchParams;
    },
    async loadContacts( page = 1 ) {
      const params = this.buildSearchParams( page );

      await this.$api.contacts.index( params )
              .then( function(response) {
                const { data, meta }  = response;
                this.contacts         = data;
                this.contactsMeta     = meta;
              }.bind( this ) )
              .catch( err => {

              });
    },
    async loadMoreContacts() {
      console.log( this.contactsMeta );
      const params = this.buildSearchParams( this.contactsMeta.current_page += 1 );

      await this.$api.contacts.index( params )
              .then( function(response) {
                const { data, meta }  = response;

                data.forEach(contact => {
                  this.contacts.push( contact );
                });

                this.contactsMeta     = meta;
              }.bind( this ) )
              .catch( err => {

              });
    }
  },
  watch: {
    search( newVal ) {
      this.loadContacts();
    }
  }
}
</script>
