import pluralize from 'pluralize'

export default (
  string: string,
  count?: number | undefined,
  inclusive?: boolean | undefined,
): string => {
  return pluralize(string, count, inclusive)
}
