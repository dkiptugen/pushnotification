@extends('frontend.includes.body')
@section('content')
    <section class="col py-3">
        <div class="accordion" id="accordionExample">
            <div class="card bg-light">
                <div class="card-header bg-dark" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left text-white font-weight-bold" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            5 Nov 2021
                        </button>
                    </h2>
                </div>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ul class="list-group">

                            <li class="list-group-item">
                                <a href="" class="text text-dark">
                                    <span class="badge badge-danger mr-3">12:30</span>Lorem ipsum
                                    dolor sit amet, consectetur adipisicing elit. Architecto atque harum molestiae
                                    recusandae tempora tenetur.
                                </a>
                            </li>
                            <li class="list-group-item"><a href=""  class="text text-dark"><span class="badge badge-danger mr-3">12:28</span>Illo laboriosam
                                    odit officia quia ut. Deserunt exercitationem expedita fuga maiores nemo numquam soluta
                                    vitae.</a></li>
                            <li class="list-group-item"><a href=""  class="text text-dark"><span class="badge badge-danger mr-3">12:23</span>At consequatur
                                    eos fugiat fugit illo illum ipsa natus odit optio, pariatur rem, reprehenderit
                                    saepe?</a></li>
                            <li class="list-group-item"><a href=""  class="text text-dark"><span class="badge badge-danger mr-3">12:00</span>Aliquid atque,
                                    autem deserunt dolores eligendi harum, illum inventore laborum nemo officiis quidem
                                    recusandae tempore?</a></li>
                            <li class="list-group-item"><a href=""  class="text text-dark"><span class="badge badge-danger mr-3">11:53</span>Alias
                                    blanditiis commodi dicta fuga obcaecati quasi totam! Accusamus asperiores at culpa, nisi
                                    optio similique!</a></li>
                            <li class="list-group-item"><a href=""  class="text text-dark"><span class="badge badge-danger mr-3">11:49</span>Atque cum
                                    dolores eligendi est excepturi impedit, inventore molestias omnis pariatur porro, quis
                                    repellat veniam.</a></li>
                            <li class="list-group-item"><a href=""  class="text text-dark"><span class="badge badge-danger mr-3">11:30</span>Atque doloribus
                                    esse et, ex excepturi non quas quia quidem reiciendis repellendus similique, sunt
                                    suscipit.</a></li>
                            <li class="list-group-item"><a href=""  class="text text-dark"><span class="badge badge-danger mr-3">11:00</span>Amet animi dicta
                                    dolor, nulla odio, pariatur perferendis porro quia quisquam rerum soluta sunt totam.</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Collapsible Group Item #1
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Collapsible Group Item #1
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('header')

@endsection
@section('footer')

@endsection
