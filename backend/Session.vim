let SessionLoad = 1
let s:so_save = &g:so | let s:siso_save = &g:siso | setg so=0 siso=0 | setl so=-1 siso=-1
let v:this_session=expand("<sfile>:p")
silent only
silent tabonly
cd ~/pig_hospital
if expand('%') == '' && !&modified && line('$') <= 1 && getline(1) == ''
  let s:wipebuf = bufnr('%')
endif
let s:shortmess_save = &shortmess
if &shortmess =~ 'A'
  set shortmess=aoOA
else
  set shortmess=aoO
endif
badd +36 app/Providers/AuthServiceProvider.php
badd +19 database/migrations/2024_01_21_051149_create_nurses_table.php
badd +1 ~/.config/nvim/lua/nvim-lspconfig.lua
badd +29 ~/.config/nvim/init.vim
badd +8 database/seeders/DoctorSeeder.php
badd +17 database/migrations/2024_01_16_070739_create_doctors_table.php
badd +24 app/Http/Controllers/PatientController.php
badd +1 app/Http/Controllers/DoctorController.php
badd +47 routes/api.php
badd +1 database/seeders/PatientSeeder.php
badd +10 database/migrations/2024_01_16_070037_create_specialities_table.php
badd +10 app/Http/Controllers/SpecialityController.php
badd +1 composer.json
badd +42 app/Http/Kernel.php
badd +10 config/sanctum.php
badd +1 .env
badd +14 routes/web.php
argglobal
%argdel
$argadd ~/pig_hospital/
set stal=2
tabnew +setlocal\ bufhidden=wipe
tabnew +setlocal\ bufhidden=wipe
tabnew +setlocal\ bufhidden=wipe
tabnew +setlocal\ bufhidden=wipe
tabnew +setlocal\ bufhidden=wipe
tabnew +setlocal\ bufhidden=wipe
tabnew +setlocal\ bufhidden=wipe
tabnew +setlocal\ bufhidden=wipe
tabrewind
edit app/Providers/AuthServiceProvider.php
argglobal
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 36 - ((16 * winheight(0) + 16) / 33)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 36
normal! 043|
lcd ~/pig_hospital
tabnext
edit ~/pig_hospital/database/seeders/PatientSeeder.php
let s:save_splitbelow = &splitbelow
let s:save_splitright = &splitright
set splitbelow splitright
wincmd _ | wincmd |
vsplit
1wincmd h
wincmd w
let &splitbelow = s:save_splitbelow
let &splitright = s:save_splitright
wincmd t
let s:save_winminheight = &winminheight
let s:save_winminwidth = &winminwidth
set winminheight=0
set winheight=1
set winminwidth=0
set winwidth=1
exe 'vert 1resize ' . ((&columns * 66 + 104) / 209)
exe 'vert 2resize ' . ((&columns * 142 + 104) / 209)
argglobal
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 27 - ((16 * winheight(0) + 16) / 33)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 27
normal! 013|
lcd ~/pig_hospital
wincmd w
argglobal
if bufexists(fnamemodify("~/pig_hospital/app/Http/Controllers/PatientController.php", ":p")) | buffer ~/pig_hospital/app/Http/Controllers/PatientController.php | else | edit ~/pig_hospital/app/Http/Controllers/PatientController.php | endif
if &buftype ==# 'terminal'
  silent file ~/pig_hospital/app/Http/Controllers/PatientController.php
endif
balt ~/pig_hospital/database/seeders/PatientSeeder.php
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 24 - ((16 * winheight(0) + 16) / 33)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 24
normal! 020|
lcd ~/pig_hospital
wincmd w
exe 'vert 1resize ' . ((&columns * 66 + 104) / 209)
exe 'vert 2resize ' . ((&columns * 142 + 104) / 209)
tabnext
edit ~/pig_hospital/app/Http/Controllers/DoctorController.php
let s:save_splitbelow = &splitbelow
let s:save_splitright = &splitright
set splitbelow splitright
wincmd _ | wincmd |
vsplit
1wincmd h
wincmd w
wincmd _ | wincmd |
split
1wincmd k
wincmd w
let &splitbelow = s:save_splitbelow
let &splitright = s:save_splitright
wincmd t
let s:save_winminheight = &winminheight
let s:save_winminwidth = &winminwidth
set winminheight=0
set winheight=1
set winminwidth=0
set winwidth=1
exe 'vert 1resize ' . ((&columns * 104 + 104) / 209)
exe '2resize ' . ((&lines * 16 + 18) / 36)
exe 'vert 2resize ' . ((&columns * 104 + 104) / 209)
exe '3resize ' . ((&lines * 16 + 18) / 36)
exe 'vert 3resize ' . ((&columns * 104 + 104) / 209)
argglobal
balt ~/pig_hospital/database/migrations/2024_01_16_070739_create_doctors_table.php
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 25 - ((16 * winheight(0) + 16) / 33)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 25
normal! 019|
lcd ~/pig_hospital
wincmd w
argglobal
if bufexists(fnamemodify("~/pig_hospital/database/seeders/DoctorSeeder.php", ":p")) | buffer ~/pig_hospital/database/seeders/DoctorSeeder.php | else | edit ~/pig_hospital/database/seeders/DoctorSeeder.php | endif
if &buftype ==# 'terminal'
  silent file ~/pig_hospital/database/seeders/DoctorSeeder.php
endif
balt ~/pig_hospital/app/Http/Controllers/DoctorController.php
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 8 - ((7 * winheight(0) + 8) / 16)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 8
normal! 0
lcd ~/pig_hospital
wincmd w
argglobal
if bufexists(fnamemodify("~/pig_hospital/database/migrations/2024_01_16_070739_create_doctors_table.php", ":p")) | buffer ~/pig_hospital/database/migrations/2024_01_16_070739_create_doctors_table.php | else | edit ~/pig_hospital/database/migrations/2024_01_16_070739_create_doctors_table.php | endif
if &buftype ==# 'terminal'
  silent file ~/pig_hospital/database/migrations/2024_01_16_070739_create_doctors_table.php
endif
balt ~/pig_hospital/app/Http/Controllers/DoctorController.php
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 13 - ((7 * winheight(0) + 8) / 16)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 13
normal! 05|
lcd ~/pig_hospital
wincmd w
exe 'vert 1resize ' . ((&columns * 104 + 104) / 209)
exe '2resize ' . ((&lines * 16 + 18) / 36)
exe 'vert 2resize ' . ((&columns * 104 + 104) / 209)
exe '3resize ' . ((&lines * 16 + 18) / 36)
exe 'vert 3resize ' . ((&columns * 104 + 104) / 209)
tabnext
edit ~/pig_hospital/app/Http/Controllers/SpecialityController.php
let s:save_splitbelow = &splitbelow
let s:save_splitright = &splitright
set splitbelow splitright
wincmd _ | wincmd |
vsplit
1wincmd h
wincmd w
let &splitbelow = s:save_splitbelow
let &splitright = s:save_splitright
wincmd t
let s:save_winminheight = &winminheight
let s:save_winminwidth = &winminwidth
set winminheight=0
set winheight=1
set winminwidth=0
set winwidth=1
exe 'vert 1resize ' . ((&columns * 104 + 104) / 209)
exe 'vert 2resize ' . ((&columns * 104 + 104) / 209)
argglobal
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 10 - ((9 * winheight(0) + 16) / 33)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 10
normal! 0
lcd ~/pig_hospital
wincmd w
argglobal
if bufexists(fnamemodify("~/pig_hospital/database/migrations/2024_01_16_070037_create_specialities_table.php", ":p")) | buffer ~/pig_hospital/database/migrations/2024_01_16_070037_create_specialities_table.php | else | edit ~/pig_hospital/database/migrations/2024_01_16_070037_create_specialities_table.php | endif
if &buftype ==# 'terminal'
  silent file ~/pig_hospital/database/migrations/2024_01_16_070037_create_specialities_table.php
endif
balt ~/pig_hospital/app/Http/Controllers/SpecialityController.php
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 10 - ((9 * winheight(0) + 16) / 33)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 10
normal! 0
lcd ~/pig_hospital
wincmd w
exe 'vert 1resize ' . ((&columns * 104 + 104) / 209)
exe 'vert 2resize ' . ((&columns * 104 + 104) / 209)
tabnext
edit ~/pig_hospital/routes/api.php
argglobal
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 47 - ((21 * winheight(0) + 16) / 33)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 47
normal! 041|
lcd ~/pig_hospital
tabnext
edit ~/pig_hospital/config/sanctum.php
argglobal
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 10 - ((9 * winheight(0) + 16) / 33)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 10
normal! 05|
lcd ~/pig_hospital
tabnext
edit ~/.config/nvim/init.vim
argglobal
balt ~/pig_hospital/app/Providers/AuthServiceProvider.php
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 29 - ((23 * winheight(0) + 16) / 33)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 29
normal! 014|
lcd ~/pig_hospital
tabnext
edit ~/.config/nvim/lua/nvim-lspconfig.lua
argglobal
balt ~/pig_hospital/app/Providers/AuthServiceProvider.php
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 32 - ((18 * winheight(0) + 16) / 33)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 32
normal! 0
lcd ~/pig_hospital
tabnext
edit ~/pig_hospital/database/migrations/2024_01_21_051149_create_nurses_table.php
argglobal
setlocal fdm=manual
setlocal fde=0
setlocal fmr={{{,}}}
setlocal fdi=#
setlocal fdl=0
setlocal fml=1
setlocal fdn=20
setlocal fen
silent! normal! zE
let &fdl = &fdl
let s:l = 19 - ((18 * winheight(0) + 16) / 33)
if s:l < 1 | let s:l = 1 | endif
keepjumps exe s:l
normal! zt
keepjumps 19
normal! 010|
lcd ~/pig_hospital
tabnext 5
set stal=1
if exists('s:wipebuf') && len(win_findbuf(s:wipebuf)) == 0 && getbufvar(s:wipebuf, '&buftype') isnot# 'terminal'
  silent exe 'bwipe ' . s:wipebuf
endif
unlet! s:wipebuf
set winheight=1 winwidth=20
let &shortmess = s:shortmess_save
let s:sx = expand("<sfile>:p:r")."x.vim"
if filereadable(s:sx)
  exe "source " . fnameescape(s:sx)
endif
let &g:so = s:so_save | let &g:siso = s:siso_save
doautoall SessionLoadPost
unlet SessionLoad
" vim: set ft=vim :
