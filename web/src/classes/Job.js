'use strict'

import ApiHasHistory from '@/common/classes/ApiHasHistory'
import sections from '@/enum/sections'

export default class Job extends ApiHasHistory {

  static get __API_POINT() {
    return 'jobs'
  }

  static get __SECTION() {
    return sections.jobs
  }

  static get __JSON_ATTR() {
    return 'job'
  }
}
