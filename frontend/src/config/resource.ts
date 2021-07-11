export const tableData = {
  data: [
    { id: 1, name: 'admin1', action: 'GET', detail: '/' },
    { id: 2, name: 'admin1', action: 'GET', detail: '/members' },
    { id: 3, name: 'admin1', action: 'PATCH', detail: '/members/member5' },
    { id: 4, name: 'admin1', action: 'PATCH', detail: '/members/member5' },
    { id: 5, name: 'admin1', action: 'GET', detail: '/members/csv' },
    { id: 6, name: 'admin1', action: 'POST', detail: '/members/member' },
    { id: 7, name: 'admin1', action: 'GET', detail: '/roles' },
    { id: 8, name: 'admin1', action: 'GET', detail: '/roles/csv' },
    { id: 9, name: 'admin1', action: 'GET', detail: '/enemies' },
    { id: 10, name: 'admin1', action: 'GET', detail: '/enemies/file/template' },
    { id: 11, name: 'test11', action: 'GET', detail: 'test action11' },
    { id: 12, name: 'test12', action: 'POST', detail: 'test action12' },
    { id: 13, name: 'test13', action: 'PUT', detail: 'test action13' },
    { id: 14, name: 'test14', action: 'PATCH', detail: 'test action14' },
    { id: 15, name: 'test15', action: 'DELETE', detail: 'test action15' },
    { id: 16, name: 'test16', action: 'GET', detail: 'test action16' },
    { id: 17, name: 'test17', action: 'POST', detail: 'test action17' },
    { id: 18, name: 'test18', action: 'PUT', detail: 'test action18' },
    { id: 19, name: 'test19', action: 'PATCH', detail: 'test action19' },
    { id: 20, name: 'test20', action: 'DELETE', detail: 'test action20' }
  ]
}

export const tableKeys = [
  { field: 'id', header: 'ID' },
  { field: 'name', header: 'Name' },
  { field: 'action', header: 'Action' },
  { field: 'detail', header: 'Detail' }
]

export const eventDate = [
  {
    id: 1,
    title: 'All Day Event',
    start: '2021-01-01'
  },
  {
    id: 2,
    title: 'Long Event',
    start: '2021-01-07',
    end: '2021-01-10'
  },
  {
    id: 3,
    title: 'Repeating Event',
    start: '2021-01-09T16:00:00'
  },
  {
    id: 4,
    title: 'Repeating Event',
    start: '2021-01-16T16:00:00'
  },
  {
    id: 5,
    title: 'Conference',
    start: '2021-01-11',
    end: '2021-01-13'
  },
  {
    id: 6,
    title: 'Meeting',
    start: '2021-01-12T10:30:00',
    end: '2021-01-12T12:30:00'
  }
]
