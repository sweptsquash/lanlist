import dayjs from 'dayjs'
import advancedFormat from 'dayjs/plugin/advancedFormat'
import customParseFormat from 'dayjs/plugin/customParseFormat'
import dayOfYear from 'dayjs/plugin/dayOfYear'
import duration from 'dayjs/plugin/duration'
import isBetween from 'dayjs/plugin/isBetween'
import isSameOrAfter from 'dayjs/plugin/isSameOrAfter'
import isSameOrBefore from 'dayjs/plugin/isSameOrBefore'
import isToday from 'dayjs/plugin/isToday'
import isTomorrow from 'dayjs/plugin/isTomorrow'
import isYesterday from 'dayjs/plugin/isYesterday'
import isoWeek from 'dayjs/plugin/isoWeek'
import localizedFormat from 'dayjs/plugin/localizedFormat'
import objectSupport from 'dayjs/plugin/objectSupport'
import pluralGetSet from 'dayjs/plugin/pluralGetSet'
import relativeTime from 'dayjs/plugin/relativeTime'
import timezone from 'dayjs/plugin/timezone'
import utc from 'dayjs/plugin/utc'
import weekday from 'dayjs/plugin/weekday'

dayjs.extend(utc)
dayjs.extend(weekday)
dayjs.extend(isToday)
dayjs.extend(isoWeek)
dayjs.extend(timezone)
dayjs.extend(duration)
dayjs.extend(dayOfYear)
dayjs.extend(isBetween)
dayjs.extend(isTomorrow)
dayjs.extend(isYesterday)
dayjs.extend(relativeTime)
dayjs.extend(pluralGetSet)
dayjs.extend(objectSupport)
dayjs.extend(isSameOrAfter)
dayjs.extend(isSameOrBefore)
dayjs.extend(advancedFormat)
dayjs.extend(localizedFormat)
dayjs.extend(customParseFormat)

export default dayjs
