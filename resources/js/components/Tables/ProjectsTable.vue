<template>
  <div class="card shadow">
    <div class="card-header border-0">
      <div class="row align-items-center">
        <div class="col">
          <h3 class="mb-0">
            {{title}}
          </h3>
        </div>
      </div>
    </div>

    <div class="table-responsive">
      <base-table class="table align-items-center table-flush"
                  thead-classes="thead-light"
                  tbody-classes="list"
                  :data="data">

        <template slot="columns">
          <th>Project</th>
          <th>Status</th>
          <th>Completion</th>
          <th></th>
        </template>

        <template slot-scope="{row}">
          <th scope="row">
            <div class="media align-items-center">
              <div class="media-body">
                  <router-link :to="{name: 'Project', params: {id: row.id}}">
                      <span class="name mb-0 text-sm">{{row.name}}</span>
                  </router-link>
              </div>
            </div>
          </th>

          <td>
            <badge class="badge-dot mr-4" :type="row.statusType">
              <i :class="`bg-${row.statusType}`"></i>
              <span class="status">{{row.status}}</span>
            </badge>
          </td>

          <td>
            <div class="d-flex align-items-center">
              <span class="completion mr-2">{{row.completion}}%</span>
              <div>
                  <base-progress :type="row.statusType"
                                 :show-percentage="false"
                                 class="pt-0"
                                 :value="row.completion"/>
              </div>
            </div>
          </td>

          <td class="text-right">
            <base-dropdown class="dropdown" position="right">

              <a slot="title" class="btn btn-sm btn-icon-only text-light" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>
              </a>

              <template>
                <a class="dropdown-item" >Edit</a>
                <a class="dropdown-item" >Delete</a>
              </template>
            </base-dropdown>
          </td>

        </template>

      </base-table>
    </div>

    <div class="card-footer d-flex justify-content-end"></div>
  </div>
</template>
<script>
  export default {
    name: 'projects-table',
    props: {
        type: {
            type: String
        },
        title: String,
        data: {
            type: Array,
            default: () => ([
                {
                    name: 'Angular Now UI Kit PRO',
                    status: 'completed',
                    statusType: 'success',
                    completion: 100
                },
                {
                    name: 'React Material Dashboard',
                    status: 'on schedule',
                    statusType: 'info',
                    completion: 90
                }
            ])
        }
    },
    data() {
      return {

      }
    }
  }
</script>
<style>
    .table-responsive {overflow: inherit !important;}
</style>
