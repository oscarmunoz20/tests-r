@extends('layouts.dashboard')

@section('style')
    <style>
        #log > div {
            color: #313131;
            border-top: 1px solid #dadada;
            padding: 9px;
            display: flex;
        }
        #log > div:first-child {
            border: 0;
        }
        .status {
                min-width: 250px;
        }
        #log {
            border: 1px solid #dadada;
            padding: 10px;
            margin-top: 20px;
            min-height: 100px;
        }
        body {
            font-family: sans-serif;

        }
        progress {
            display: block;
            width: 100%;
            transition: opacity 0.5s linear;
        }
        progress[value="1"] {
            opacity: 0.5;
        }
    </style>

@endsection

@section('script')
    <script src="https://cdn.rawgit.com/naptha/tesseract.js/1.0.7/dist/tesseract.js"></script>

    <script>
    function progressUpdate(packet){
            var log = document.getElementById('log');
            if(log.firstChild && log.firstChild.status === packet.status){
                    if('progress' in packet){
                            var progress = log.firstChild.querySelector('progress')
                            progress.value = packet.progress
                    }
            }else{
                    var line = document.createElement('div');
                    line.status = packet.status;
                    var status = document.createElement('div')
                    status.className = 'status'
                    status.appendChild(document.createTextNode(packet.status))
                    line.appendChild(status)
                    if('progress' in packet){
                            var progress = document.createElement('progress')
                            progress.value = packet.progress
                            progress.max = 1
                            line.appendChild(progress)
                    }
                    if(packet.status == 'done'){
                            var pre = document.createElement('pre')
                            pre.appendChild(document.createTextNode('Laguange installed'))
                            line.innerHTML = ''
                            line.appendChild(pre)
                    }
                    log.insertBefore(line, log.firstChild)
            }
    }
    function recognizeFile(file){
            document.querySelector("#log").innerHTML = ''
            Tesseract.recognize(file, {
                    lang: document.querySelector('#langsel').value
            })
                    .progress(function(packet){
                            console.info(packet)
                            progressUpdate(packet)
                    })
                    .then(function(data){
                            console.log(data)
                            progressUpdate({ status: 'done', data: data })
                    })
    }
    </script>

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <select id="langsel" onchange="window.lastFile && recognizeFile(window.lastFile)">
                <option value='afr'     > Afrikaans             </option>
                <option value='ara'     > Arabic                </option>
                <option value='aze'     > Azerbaijani           </option>
                <option value='bel'     > Belarusian            </option>
                <option value='ben'     > Bengali               </option>
                <option value='bul'     > Bulgarian             </option>
                <option value='cat'     > Catalan               </option>
                <option value='ces'     > Czech                 </option>
                <option value='chi_sim' > Chinese               </option>
                <option value='chi_tra' > Traditional Chinese   </option>
                <option value='chr'     > Cherokee              </option>
                <option value='dan'     > Danish                </option>
                <option value='deu'     > German                </option>
                <option value='ell'     > Greek                 </option>
                <option value='eng'     selected> English                </option>
                <option value='enm'     > English (Old)         </option>
                <option value='meme'     > Internet Meme                </option>
                <option value='epo'     > Esperanto             </option>
                <option value='epo_alt' > Esperanto alternative </option>
                <option value='equ'     > Math                  </option>
                <option value='est'     > Estonian              </option>
                <option value='eus'     > Basque                </option>
                <option value='fin'     > Finnish               </option>
                <option value='fra'     > French                </option>
                <option value='frk'     > Frankish              </option>
                <option value='frm'     > French (Old)          </option>
                <option value='glg'     > Galician              </option>
                <option value='grc'     > Ancient Greek         </option>
                <option value='heb'     > Hebrew                </option>
                <option value='hin'     > Hindi                 </option>
                <option value='hrv'     > Croatian              </option>
                <option value='hun'     > Hungarian             </option>
                <option value='ind'     > Indonesian            </option>
                <option value='isl'     > Icelandic             </option>
                <option value='ita'     > Italian               </option>
                <option value='ita_old' > Italian (Old)         </option>
                <option value='jpn'     > Japanese              </option>
                <option value='kan'     > Kannada               </option>
                <option value='kor'     > Korean                </option>
                <option value='lav'     > Latvian               </option>
                <option value='lit'     > Lithuanian            </option>
                <option value='mal'     > Malayalam             </option>
                <option value='mkd'     > Macedonian            </option>
                <option value='mlt'     > Maltese               </option>
                <option value='msa'     > Malay                 </option>
                <option value='nld'     > Dutch                 </option>
                <option value='nor'     > Norwegian             </option>
                <option value='pol'     > Polish                </option>
                <option value='por'     > Portuguese            </option>
                <option value='ron'     > Romanian              </option>
                <option value='rus'     > Russian               </option>
                <option value='slk'     > Slovakian             </option>
                <option value='slv'     > Slovenian             </option>
                <option value='spa'     > Spanish               </option>
                <option value='spa_old' > Old Spanish           </option>
                <option value='sqi'     > Albanian              </option>
                <option value='srp'     > Serbian (Latin)       </option>
                <option value='swa'     > Swahili               </option>
                <option value='swe'     > Swedish               </option>
                <option value='tam'     > Tamil                 </option>
                <option value='tel'     > Telugu                </option>
                <option value='tgl'     > Tagalog               </option>
                <option value='tha'     > Thai                  </option>
                <option value='tur'     > Turkish               </option>
                <option value='ukr'     > Ukrainian             </option>
                <option value='vie'     > Vietnamese            </option>
             </select>
            <button onclick="recognizeFile('images/cosmic.png')">{{ __('messages.installLanguage') }}</button>
            <div id="log"></div>

        </div>
    </div>
@endsection