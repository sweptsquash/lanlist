import { $constants } from '@/Constants/Constants'

export const useUser = computed(() => usePage().props.user ?? null)

export const useIsAuthenticated = computed(() => usePage().props.user !== null)

export const useIsAdmin = computed(() => usePage().props.isAdmin)

export const useIsImpersonating = computed(() => usePage().props.isImpersonating)

export const useIsVerified = computed(() => usePage().props.user?.email_verified_at !== null)

export const useUserDateFormat = computed(() => {
  const userPropFormat = usePage().props.user?.date_format

  if (userPropFormat) {
    const userFormat = $constants.dateFormats.find((format) => format.php === userPropFormat)

    if (userFormat) {
      return userFormat.js
    }
  }

  return 'DD/MM/YYYY HH:mm:ss'
})
