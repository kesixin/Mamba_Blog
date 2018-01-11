<div class="panel panel-default author">
    @inject('userPresenter','App\Presenters\UserPresenter')
    <?php
        $author = isset($user->id) ? $user : $userPresenter->getUserInfo();
    ?>
    <div class="panel-heading">
        <h3 class="panel-title">{{ $author->name }}</h3>
    </div>
    <div class="panel-body">
        <div class="row text-center">
            <img src="{{ asset('uploads/avatar')."/".$author->user_pic }}" class="img-circle author-avatar" alt="User Image">
        </div>
        <div class="row text-center author-footer">
            <?php
                $github_url = '';
                $qq = '';
                if(!isset($user->id)||$user->id == 1){
                    $github_url = $systemPresenter->getKeyValue('github_url');
                    $qq = $systemPresenter->getKeyValue('qq');
                }
            ?>

                @if ($github_url != "")
                    <span class="icon-github" style="padding-left:20px;">
                    <a href='{{ $github_url }}' target="_blank">GitHub</a>
                </span>
                @endif

               @if($qq != "")
                    <span class="qq" style="padding-left:20px;margin-left:10px;">
                        {{ $qq }}
                    </span>
                @endif
        </div>
    </div>
</div>