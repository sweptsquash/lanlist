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

  return Intl.NumberFormat(typeof navigator !== 'undefined' ? navigator.language : 'en-GB', {
    ...formatOptions,
    ...options,
  }).format(value)
}
