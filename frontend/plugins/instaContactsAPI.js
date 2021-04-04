import ContactsAPI from '~/api/contacts'

export default function({ $axios }, inject) {
  const api = {
    contacts: ContactsAPI( $axios ),
  }

  inject('api', api);
}