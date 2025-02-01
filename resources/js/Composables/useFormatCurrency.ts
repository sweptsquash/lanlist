import { isNumber } from 'lodash'

export default function useFormatCurrency(
  value: number | bigint | Intl.StringNumericLiteral,
  currencyCode: string = 'GBP',
  withSymbol: boolean = true,
  options = {},
): string {
  let formatOptions: Intl.NumberFormatOptions | undefined = {
    currency: currencyCode,
    style: 'currency',
  }

  if (!withSymbol || currencyCode === null) {
    formatOptions = {}
  }

  isNumber(value)

  return Intl.NumberFormat(typeof navigator !== 'undefined' ? navigator.language : 'en-GB', {
    ...formatOptions,
    ...options,
  }).format(isNumber(value) ? value / 100 : value)
}
