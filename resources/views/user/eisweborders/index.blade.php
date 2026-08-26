<x-user-layout title="">

    <h1>Eisweborders</h1>

    <form method="get"
          accept-charset="utf-8"
          id="searchform"
          action="{{ route('user.eisweborders.index') }}">

        <div class="row">

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="2"
                              label="2"
                              :value="request('2')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="3"
                              label="3"
                              :value="request('3')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="6"
                              label="6"
                              :value="request('6')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="7"
                              label="7"
                              :value="request('7')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <x-form.input name="23"
                              label="23"
                              :value="request('23')"
                              maxlength="50" />
            </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2 pt-2">
                <br />
                <x-form.button>Submit</x-form.button>
                <a href="{{ route('user.eisweborders.index') }}"
                   class="btn btn-sm btn-secondary">Reset</a>
            </div>

        </div>

    </form>

    <br />
    <br />

    {{ $eisweborders->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th><a
                           href="{{ Request::fullUrlWithQuery(['sort_field' => 'ID', 'sort_direction' => $sort_direction]) }}">ID</a>
                    </th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                    <th>7</th>
                    <th>8</th>
                    <th>9</th>
                    <th>10</th>
                    <th>11</th>
                    <th>12</th>
                    <th>13</th>
                    <th>14</th>
                    <th>15</th>
                    <th>16</th>
                    <th>17</th>
                    <th>18</th>
                    <th>19</th>
                    <th>20</th>
                    <th>21</th>
                    <th>22</th>
                    <th>23</th>
                    <th>24</th>
                    <th>25</th>
                    <th>26</th>
                    <th>27</th>
                    <th>28</th>
                    <th>29</th>
                    <th>30</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eisweborders as $eisweborder)
                    <tr>
                        <td>{{ $eisweborder->ID }}</td>
                        <td>{{ $eisweborder['1'] }}</td>
                        <td>{{ $eisweborder['2'] }}</td>
                        <td>{{ $eisweborder['3'] }}</td>
                        <td>{{ $eisweborder['4'] }}</td>
                        <td>{{ $eisweborder['5'] }}</td>
                        <td>{{ $eisweborder['6'] }}</td>
                        <td>{{ $eisweborder['7'] }}</td>
                        <td>{{ $eisweborder['8'] }}</td>
                        <td>{{ $eisweborder['9'] }}</td>
                        <td>{{ $eisweborder['10'] }}</td>
                        <td>{{ $eisweborder['11'] }}</td>
                        <td>{{ $eisweborder['12'] }}</td>
                        <td>{{ $eisweborder['13'] }}</td>
                        <td>{{ $eisweborder['14'] }}</td>
                        <td>{{ $eisweborder['15'] }}</td>
                        <td>{{ $eisweborder['16'] }}</td>
                        <td>{{ $eisweborder['17'] }}</td>
                        <td>{{ $eisweborder['18'] }}</td>
                        <td>{{ $eisweborder['19'] }}</td>
                        <td>{{ $eisweborder['20'] }}</td>
                        <td>{{ $eisweborder['21'] }}</td>
                        <td>{{ $eisweborder['22'] }}</td>
                        <td>{{ $eisweborder['23'] }}</td>
                        <td>{{ $eisweborder['24'] }}</td>
                        <td>{{ $eisweborder['25'] }}</td>
                        <td>{{ $eisweborder['26'] }}</td>
                        <td>{{ $eisweborder['27'] }}</td>
                        <td>{{ $eisweborder['28'] }}</td>
                        <td>{{ $eisweborder['29'] }}</td>
                        <td>{{ $eisweborder['30'] }}</td>
                        <td class="actions">
                            <a href="{{ route('user.eisweborders.show', $eisweborder->ID) }}"
                               class="btn btn-xs btn-secondary">view</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $eisweborders->withQueryString()->links() }}

    <br />
    <br />

</x-user-layout>
