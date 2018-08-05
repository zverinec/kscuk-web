#!/usr/bin/env python

import os, sys
from PIL import Image

SCALED_IMAGE_HEIGHT = 1080
THUMBNAIL_WIDTH = 291
SCALED_IMAGE_QUALITY = 90
THUMBNAIL_QUALITY = 70


def get_dir():
    if len(sys.argv) > 1:
        return sys.argv[1]
    else:
        return input("Insert image directory path: ")


def get_files(directory):
    try:
        files = os.listdir(directory)
        return files
    except (PermissionError, OSError) as err:
        print("Unable to access directory: " + str(err))
        exit(1)


def make_output_dir(directory):
    if not os.path.isdir(os.path.join(directory, "result")):
        try:
            os.mkdir(os.path.join(directory, "result"))
        except PermissionError as err:
            print("No permission to create directory for output images: " + str(err))
            exit(1)


def scale_down(image, file, directory, ratio):
    new_width = SCALED_IMAGE_HEIGHT * ratio
    image = image.resize((round(new_width), SCALED_IMAGE_HEIGHT), Image.ANTIALIAS)

    try:
        image.save(os.path.join(directory, "result", file), quality=SCALED_IMAGE_QUALITY)
    except IOError as ex:
        print("Saving " + file + " in 1080p failed: " + str(ex))


def make_thumbnail(image, file, directory, ratio):
    new_height = THUMBNAIL_WIDTH / ratio
    image = image.resize((THUMBNAIL_WIDTH, round(new_height)), Image.ANTIALIAS)
    filename, ext = os.path.splitext(file)

    try:
        image.save(os.path.join(directory, "result", filename + "-thumb.jpg"), "JPEG", quality=THUMBNAIL_QUALITY)
    except IOError as ex:
        print("Saving the thumbnail of " + file + " failed: " + str(ex))


def process_images(files, directory):

    for file in files:
        if not os.path.isfile(os.path.join(directory, file)):
            continue

        try:
            image = Image.open(os.path.join(directory, file))
        except IOError as ex:
            print("Opening the file " + file + " failed: " + str(ex))
            continue

        ratio = image.width / image.height

        scale_down(image, file, directory, ratio)
        make_thumbnail(image, file, directory, ratio)

        image.close()


directory = get_dir()
make_output_dir(directory)
process_images(get_files(directory), directory)
