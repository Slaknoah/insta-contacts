export default $axios => ({
  async index( params ) {
    try {
      const response = await $axios.get('/api/v1/contacts', {
        params: params
      })
      return response.data;
    } catch(err) {
      throw err;
    }
  },

  async getUserContacts( params ) {
    try {
      const response = await $axios.get('/api/v1/user-contacts', {
        params: params
      })
      return response.data;
    } catch(err) {
      throw err;
    }
  },

  async bookmark( contactId ) {
    try {
      const response = await $axios.$put( `/api/v1/contacts/${contactId}/bookmark` );

      return response;
    } catch ( err ) {
      throw err;
    }
  }
})