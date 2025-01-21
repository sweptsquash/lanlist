export default function useFormatNumber(
    value: number | bigint,
    options: Intl.NumberFormatOptions | undefined = {},
): string {
    return Intl.NumberFormat(
        typeof navigator !== 'undefined' ? navigator.language : 'en-GB',
        options,
    ).format(value)
}
