# 리딩 리스트 테마
## 개요
* 작성자: [아카이브](http://akaiv.com)의 [심철환](http://simcheolhwan.com)

## 테마 설치
* 워드프레스 테마 디렉토리에 이 리파지토리를 클론합니다.
```bash
cd wp-content/themes
git clone https://github.com/s10n/reading.git
```
* 서브모듈을 초기화하고 업데이트합니다.
```bash
cd reading
git submodule init
git submodule update
```
* `npm install`을 수행합니다. 이 명령은 자동으로 `bower.json`과 `package.json`의 디펜던시를 가져오고 `grunt build`를 실행합니다.
* 이제 워드프레스 관리자 화면에서 테마를 설정하십시오.
