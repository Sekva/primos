# -*- mode: python ; coding: utf-8 -*-

block_cipher = None


a = Analysis(['cliente.py'],
             pathex=['G:\\win_build_tools\\mingw\\home\\matheuss\\primos\\grid\\cliente'],
             binaries=[],
             datas=[('libgcc_s_seh-1.dll', '.'), ('libgmp-10.dll', '.'), ('libgmpxx-4.dll', '.'), ('libstdc++-6.dll', '.'), ('libtqp.so', '.'), ('libwinpthread-1.dll', '.')],
             hiddenimports=[],
             hookspath=[],
             runtime_hooks=[],
             excludes=[],
             win_no_prefer_redirects=False,
             win_private_assemblies=False,
             cipher=block_cipher,
             noarchive=False)
pyz = PYZ(a.pure, a.zipped_data,
             cipher=block_cipher)
exe = EXE(pyz,
          a.scripts,
          a.binaries,
          a.zipfiles,
          a.datas,
          [],
          name='cliente',
          debug=False,
          bootloader_ignore_signals=False,
          strip=False,
          upx=True,
          upx_exclude=[],
          runtime_tmpdir=None,
          console=True , icon='icone.ico')
